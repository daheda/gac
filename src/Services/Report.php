<?php
namespace Gac\Services;
use Gac\Dao\Connexion as Dao;

class Report 
{
    private $connection;
    const DEFAULT_DATE = '2012-02-15';
    const DEFAULT_START_TOP = '08:00';
    const DEFAULT_END_TOP = '18:00';


    public function __construct()
    {
        $this->connection = Dao::getInstance()->getConnection();
    }

    private function humanReadable($total)
    {
         return sprintf('%02d:%02d:%02d', ($total/3600),($total/60%60), $total%60);
    }

    public function getTotalCallAfterOneDate($date = null) : array
    {
        $date = $date ?? self::DEFAULT_DATE;
        $result = [];
        $statement = $this->connection->prepare("SELECT SUM(duree_total) AS total FROM ".ImportTickestAppels::TABLE_DETAIL." WHERE date_facture >= :date_limite ");
        $statement->bindParam(':date_limite', $date);
        if ($statement->execute()) {
            if ($data = $statement->fetch(\PDO::FETCH_ASSOC)){
                $total = $data['total'];
                return [
                    "Durée totale réelle des appels effectués après le 15/02/2012 (inclus): ",
                    "En secondes : $total s ",
                    "En heure: {$this->humanReadable($total)}" 
                ];
            }
        }
        return $result;
    }

    public function getTopN($start = null, $end=null, $limit = 10) : array
    {
        $start = $start ?? self::DEFAULT_START_TOP;
        $end = $end ?? self::DEFAULT_END_TOP;
        $result = [];
        $sql = "select numero_abonne, sum(duree_total)  as total from ".ImportTickestAppels::TABLE_DETAIL." where heure_facture <= :start and heure_facture <= :end group by numero_abonne order by total desc limit  {$limit}";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':start', $start);
        $statement->bindParam(':end', $end);

        if ($statement->execute()) {
            $result[] = "TOP 10 des volumes data facturés en dehors de la tranche horaire 8h00-18h00, par abonné";
            $i = 0;
            while ($data = $statement->fetch(\PDO::FETCH_ASSOC)){
                $total = $data['total'];
                ++$i;
                $result[] = implode("\n", [
                    "{$i}/ Abonné #{$data['numero_abonne']}" ,
                    "=================================",
                    "En secondes : $total s ",
                    "En heure: {$this->humanReadable($total)}" ,
                    "\n"
                ]);
            }
        }
        return $result;
    }

    public function getTotalSms() : array
    {
        
        $result = [];
        $sql = "select count(*) as total from detail_appel inner join type_appel
        on detail_appel.type_appel_id = type_appel.id
        where type_appel.id in (select id from type_appel where libelle like '%envoi%sms%')";
        $statement = $this->connection->prepare($sql);
      
        if ($statement->execute()) {
            
            if ($data = $statement->fetch(\PDO::FETCH_ASSOC)){
                $total = $data['total'];
                return [
                    "Quantité totale de SMS envoyés par l'ensemble des abonnés",
                    "=========================",
                    "Total: $total" 
                ];
            }
        }
        return $result;
    }
}