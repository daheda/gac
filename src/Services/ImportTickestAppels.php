<?php
namespace Gac\Services;
use Gac\Dao\Connexion as Dao;
class ImportTickestAppels
{
    private $filename;
    private $connection;

    private $numberImported = 0;
    private $numberError = 0;
    private $typeIdCache = [];

    const TABLE_DETAIL = 'detail_appel';
    const TABLE_TYPE_APPEL = 'type_appel';

    # constant for CSV FIELDS
    const CSV_TYPE_FACTURE = 7;
    const CSV_VOLUME_FACTURE = 6;
    const CSV_VOLUME_REEL = 5;
    const CSV_HEURE_FACTURE = 4;
    const CSV_DATE_FACTURE = 3;
    const CSV_NUM_ABONNEE = 2;

    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->connection = Dao::getInstance()->getConnection();
    }

    private function getTypeAppel(array $data)
    {
        $typeId = null;
        if (in_array($data[self::CSV_TYPE_FACTURE], $this->typeIdCache)){
            return $this->typeIdCache[$data[self::CSV_TYPE_FACTURE]];
        }
        try {
            $statement = $this->connection->prepare("INSERT INTO ".self::TABLE_TYPE_APPEL." (libelle) VALUES (:libelle)");
            $statement->bindParam(':libelle', $data[self::CSV_TYPE_FACTURE]);
            if ($statement->execute()) {
                $typeId = $this->connection->lastInsertId(); 
            }
            $this->typeIdCache[$data[self::CSV_TYPE_FACTURE]] = $typeId;
            return $typeId;
        } catch (\Exception $e){
            throw $e;
        }
        return $typeId;
    }

    private function getNumberOfSecondes($time)
    {
        $time = preg_replace("/^([\d]{2})\:([\d]{2})\:([\d]{2})$/", "$1:$2:$3", $time);
        sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
        return $hours * 3600 + $minutes * 60 + $seconds;
    }

    private function isTimeFormat($data)
    {
        return preg_match('/^([\d]{2})\:([\d]{2})\:([\d]{2})$/', $data);
    }

    private function persistDetail(int $typeId, array $data)
    {
        
        $sql = "INSERT INTO ".self::TABLE_DETAIL." (numero_abonne, date_facture, heure_facture, duree_total, duree_facture, type_appel_id)
                VALUES (:numero_abonne, :date_facture, :heure_facture, :duree_total, :duree_facture, :type_appel_id)";
        $statement = $this->connection->prepare($sql);

        $dateFacture =  \DateTime::createFromFormat('d/m/Y', $data[self::CSV_DATE_FACTURE])->format('Y-m-d');
        
        $numeroAbonne = $data[self::CSV_NUM_ABONNEE];

        $heureFacture = null;
        if ($this->isTimeFormat($data[self::CSV_HEURE_FACTURE])) {
            $heureFacture = \DateTime::createFromFormat('H:i:s', $data[self::CSV_HEURE_FACTURE])->format('H:i:s');
        }

        if ($this->isTimeFormat($data[self::CSV_VOLUME_REEL])) {
            $dureeTotal = $this->getNumberOfSecondes($data[self::CSV_VOLUME_REEL]);
        } else {
            $dureeTotal = (int)$data[self::CSV_VOLUME_REEL];
        }

        if ($this->isTimeFormat($data[self::CSV_VOLUME_FACTURE])) {
            $dureeFacture = $this->getNumberOfSecondes($data[self::CSV_VOLUME_FACTURE]);
        } else {
            $dureeFacture = (int)$data[self::CSV_VOLUME_FACTURE];
        }

        $statement->bindParam(':date_facture', $dateFacture);
        $statement->bindParam(':numero_abonne', $numeroAbonne);
        $statement->bindParam(':heure_facture', $heureFacture);
        $statement->bindParam(':duree_total', $dureeTotal);
        $statement->bindParam(':duree_facture', $dureeFacture);
        $statement->bindParam(':type_appel_id', $typeId);

        if ($statement->execute()) {
            return $this->connection->lastInsertId(); 
        }
        return null;
    }

    private function persist($data)
    {
        try {

            //insert type
            $typeId = $this->getTypeAppel($data);
            if (null === $typeId) {
                throw new \Exception("Invalid TypeAppel");
            }
            
            // insert details
            if ($this->persistDetail($typeId, $data)) {
                $this->numberImported += 1; 
            } else {
                $this->numberError += 1;
            }

        } catch (\Excaption $e) {
            print_r($data);
            throw $e;
        }
    }

    public function process()
    {
        try {
            
            $file = fopen($this->filename, 'r');
            set_time_limit(0);
            $start = 0;
            while (($data = fgetcsv($file, 0, \Config::CSV_SEPARATOR,'"')) != FALSE){ 
                if ($start <= 2){
                    $start +=1;
                    continue;
                }
                array_map('trim', $data);
                $this->persist($data);
            }
           fclose($file);
           return true;    
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getNumberImported()
    {
        return $this->numberImported;
    }
    public function getNumberError()
    {
        return $this->numberError;
    }
}