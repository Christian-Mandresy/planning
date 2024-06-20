<?php

class Circuit extends CI_Model {

    /*
    return all Circuits.
    created by your name
    created at 13-09-22.
    */
    public function getAll($limit,$start) {
		$this->db->from('circuit');
		$this->db->order_by("datedebut", "desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get(); 
		return $query->result();
    }

	public function get_count() {
        return $this->db->count_all('circuit');
    }

	public function getCircuitMois($daty)
	{
		//[0]=mois [1]=annee
		$datsplit=explode('-',$daty,2);
		$sql="SELECT d.id, d.idcircuit, d.datedebut, d.datefin,gestiontransport, place,ci.client,tv.numero,chau.nom as chauffeur,dep.nom as depart,ar.nom as arrive from detailcircuit as d
join lieu as dep on dep.id=depart
join lieu as ar on ar.id=arrive
join circuit as ci on d.idcircuit = ci.id 
left join trajetsvoiture as tv on tv.idtrajet = d.id
left join chauffeur as chau on chau.id = tv.idchauffeur where MONTH(d.datedebut)= ? and YEAR(d.datedebut)= ?";
		$query =  $this->db->query($sql, array($datsplit[0],$datsplit[1]));
        return $query->result();

	}
    /*
    function for create Circuit.
    return Circuit inserted id.
    created by your name
    created at 13-09-22.
    */
    public function insert($data) {
        $this->db->insert('circuit', $data);
        return $this->db->insert_id();
    }
    /*
    return Circuit by id.
    created by your name
    created at 13-09-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('circuit')->result();
    }

	public function getDataByIdArray($id)
	{
		$this->db->where('id', $id);
        return $this->db->get('circuit')->result_array();
	}
    /*
    function for update Circuit.
    return true.
    created by your name
    created at 13-09-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('circuit', $data);
        return true;
    }

    public function insertWithTrajet($detailcircuit,$circuit)
    {
        $this->db->trans_Start();
        $this->db->insert('circuit', $circuit);
        $idcircuit=$this->db->insert_id();
        $adjacence=array(
            array(
            'trajet' => null,
            'trajetadj' => null
            )
        );
        for($i=0;$i<count($detailcircuit);$i++)
        {
            $detailcircuit[$i]['idcircuit']=$idcircuit;
            if($i==0 && $i!=count($detailcircuit)-1)
            {
                $this->db->insert('detailcircuit',$detailcircuit[$i]);
                $iddetail=$this->db->insert_id();
                $adjacence[$i]['trajet']=$iddetail;
            }
            else
            {
                $this->db->insert('detailcircuit',$detailcircuit[$i]);
                $iddetail=$this->db->insert_id();
                $adjacence[$i-1]['trajetadj']=$iddetail;
                if($i!=count($detailcircuit)-1)
                {
                    $trajetadjacent=array(
                        'trajet' => $iddetail,
                        'trajetadj' => null
                    );
                    array_push($adjacence,$trajetadjacent);
                }
                
            }

        }
        if(count($detailcircuit)!=1)
        {
            $this->db->insert_batch('listeadjacence',$adjacence);
        }
        

        $this->db->trans_Complete();
    }

	public function ModifWithTrajet($detailcircuit,$circuit,$idancien)
	{

		$this->db->trans_Start();
			$sqldeleteAdj="DELETE from listeadjacence where trajet 
			in (select id from detailcircuit where idcircuit = ? ) or trajetadj 
			in (select id from detailcircuit where idcircuit = ? )";
			$this->db->query($sqldeleteAdj, array($idancien,$idancien));

			$sqldeleteTrajet="DELETE from detailcircuit where idcircuit=? ";
			if($this->db->query($sqldeleteTrajet, array($idancien))==false)
			{
				return false;
			}
			$sqldeletecircuit="DELETE from circuit where id = ?";
			$this->db->query($sqldeletecircuit, array($idancien));

			$this->insertWithTrajet($detailcircuit,$circuit);
		$this->db->trans_Complete();
	}

    /**
     * 
     * tout les  trajets lié au circuit
     */
    
    
    public function getAlltrajets($idcircuit)
    {
        $this->db->where("idcircuit",$idcircuit);
        $this->db->order_by("tdatedebut", "asc");
        return $this->db->get('trajetdetail')->result();
    }

	/**
     * 
     * tout les  trajets lié au circuit en array
     */
    
    
    public function getAlltrajetsArray($idcircuit)
    {
        $this->db->where("idcircuit",$idcircuit);
        $this->db->order_by("tdatedebut", "asc");
        return $this->db->get('trajetdetail')->result_array();
    }

    /**
     * trajets par voiture
     * 
     *
     */
    public function planningvoiture($numero,$limit, $start)
    {
        $sql="SELECT numero, idprestataire, vt.nom, chauffeur, vt.id, vt.datedebut, vt.datefin, idcircuit, idchauffeur,dep.nom as depart,
		ar.nom as arrive,c.client from voituretrajet as vt 
		join lieu as dep on dep.id=vt.depart 
		join lieu as ar on ar.id=vt.arrive
		left join circuit as c on c.id =vt.idcircuit
         where numero= ?  order by datedebut desc,datefin desc LIMIT ? OFFSET ?";

        $query =  $this->db->query($sql, array($numero,$limit,(int)$start));
        return $query->result();
    }

	/**
	 * count planning par voiture
	 */

	 public function countplanning($numero)
	 {
		$sql="SELECT count(numero)as nbr from voituretrajet as vt 
		join lieu as dep on dep.id=vt.depart 
		join lieu as ar on ar.id=vt.arrive
		left join circuit as c on c.id =vt.idcircuit
         where numero= ?";

        $query =  $this->db->query($sql, array($numero));
        return $query->result()[0]->nbr;
	 }


	 /**
     * trajets par chauffeur
     * 
     *
     */
    public function planningchauffeur($idchauffeur,$limit, $start)
    {
        $sql="SELECT numero, idprestataire, vt.nom, chauffeur, vt.id, vt.datedebut, vt.datefin, idcircuit, idchauffeur,dep.nom as depart,
		ar.nom as arrive,c.client from voituretrajet as vt 
		join lieu as dep on dep.id=vt.depart 
		join lieu as ar on ar.id=vt.arrive
		left join circuit as c on c.id =vt.idcircuit
         where vt.idchauffeur= ?  order by datedebut desc LIMIT ? OFFSET ?";

        $query =  $this->db->query($sql, array($idchauffeur,$limit,(int)$start));
        return $query->result();
    }

	/**
	 * count planning par chauffeur
	 */

	public function countplanningchauffeur($idchauffeur)
	{
	   $sql="SELECT count(idchauffeur)as nbr from voituretrajet as vt 
	   join lieu as dep on dep.id=vt.depart 
	   join lieu as ar on ar.id=vt.arrive
	   left join circuit as c on c.id =vt.idcircuit
		where idchauffeur= ?";

	   $query =  $this->db->query($sql, array($idchauffeur));
	   return $query->result()[0]->nbr;
	}

    /**
     *  recherche de trajet par id
     */

     public function getTrajet($idtrajet)
     {
		$sql="SELECT td.*,circuit.client from trajetdetail as td left join circuit on td.idcircuit=circuit.id where td.id=? ";
		$query =  $this->db->query($sql,array($idtrajet));
        return $query->result();
     }

	 /**
	  * trajet principaux avant et apres
	  */
	  public function getVoisin($idtrajet,$idcircuit)
	  {
		$voisin=array();
		$sql1="SELECT trajet from listeadjacence as la join detailcircuit as d 
		on trajet=id where trajetadj = ? and idcircuit = ? ";
		$query =  $this->db->query($sql1,array($idtrajet,$idcircuit));
		$val1=$query->result();
		if(empty($val1))
		{
			array_push($voisin,null) ;
		}
		else
		{
			array_push($voisin,$val1[0]->trajet) ;
		}
        

		$sql2="SELECT trajetadj from listeadjacence as la1 join detailcircuit as 
		d1 on trajetadj=id where trajet = ? and idcircuit = ? ";
		$query2 =  $this->db->query($sql2,array($idtrajet,$idcircuit));
		$val2=$query2->result();
		
		if(empty($val2))
		{
			array_push($voisin,null) ;
		}
		else
		{
			array_push($voisin,$val2[0]->trajetadj) ;
		}
		return $voisin;
	  }
     
    /**
     * les voitures disponible pour un trajet
     * 
     */
    public function getDispo($datedebut,$datefin)
    {

        $sql = "SELECT actu.numero,actu.place,actu.status,actu.nom,actu.contact,actu.datedebut,lieuarrive,datefin,depart,
        arrive,dateprochain,lieuprochain,departprochain,idavant,idapres,difference,idchauffeur from
(SELECT v.numero,v.place,v.status,pr.nom,pr.contact,vt.datedebut,vt.arrive as lieuarrive,vt.datefin,ld.nom as depart,
        la.nom arrive,vt.idchauffeur
        ,TIMESTAMPDIFF(MINUTE,vt.datefin, ? ) as difference,vt.id as idavant from vehicule as v 
                left join prestataire as pr 
                    on v.idprestataire=pr.id
                left join voituretrajet as vt 
                    on v.numero = vt.numero
                    and (vt.datedebut=(select max(datedebut) from voituretrajet as vt3 where numero=v.numero and vt3.datefin<  date_add(?,interval 5 minute) ) or vt.depart is null)
                left join lieu as ld
                    on vt.depart = ld.id
                left join lieu as la
                    on vt.arrive = la.id
where v.numero not in (select numero from voituretrajet as vt2 where ( vt2.datedebut between date_add(?,interval 5 minute) and date_sub(?,interval 5 minute)) 
or(vt2.datefin between date_add(?,interval 5 minute) and date_sub(?,interval 5 minute) ) 
or(date_add(?,interval 5 minute) between vt2.datedebut and vt2.datefin)) 
and v.numero not in (select numero from entretien as en where ( en.datedebut between date_add(?,interval 5 minute) and date_add(?,interval 5 minute) ) 
or( en.datefin between date_add(?,interval 5 minute) and date_add(?,interval 5 minute) ) or(date_add(?,interval 5 minute) between en.datedebut and en.datefin) )
and v.status=1
) as actu left join (select la.*,vt.datedebut as dateprochain,dep.nom as departprochain,dep.id as lieuprochain,vt.id as idapres,vt.numero from listeadjacence as la 
join voituretrajet as vt on la.trajetadj=vt.id 
join lieu as dep on dep.id=vt.depart 
join lieu as ar on ar.id=vt.arrive ) as trajetadj on trajetadj.trajet=actu.idavant and trajetadj.numero=actu.numero order by actu.nom";

        $query =  $this->db->query($sql, array($datedebut,$datedebut,$datedebut,$datefin,$datedebut,$datefin,$datedebut,$datedebut,$datefin,$datedebut,$datefin,$datedebut));
        return $query->result();
    }

    /**
     * trajets en retour à vide vide disponible 
     */
    public function voitureavide($datedebut,$datefin)
    {
        $sql = "SELECT actu.numero,actu.place,actu.status,actu.nom,actu.contact,actu.datedebut, 
        actu.lieuarrive,actu.datefin,actu.depart,
		actu.idchauffeur,
        actu.arrive,
        actu.idavant,
        actu.difference,trajetadj.dateprochain,trajetadj.departprochain,trajetadj.idapres,trajetadj.lieuprochain
        FROM ( 
            SELECT v.numero,v.place,v.status,pr.nom,pr.contact,vt.datedebut, 
            vt.arrive as lieuarrive,vt.datefin,ld.nom as depart, 
            la.nom arrive,
            vt.id as idavant,
			vt.idchauffeur,
            TIMESTAMPDIFF(MINUTE,vt.datedebut, ? ) as difference 
            from vehicule as v 
            left join prestataire as pr on v.idprestataire=pr.id 
            join voituretrajet as vt 
            on v.numero = vt.numero and vt.datedebut >= DATE_SUB( ? , INTERVAL 2 DAY) 
            and vt.datedebut <= ? and vt.idcircuit is null
            left join lieu as ld on vt.depart = ld.id 
            left join lieu as la on vt.arrive = la.id  
            where vt.datedebut is not null and v.numero not in 
            (select numero from voituretrajet as vt2 where vt2.id != vt.id and 
            ( ( vt2.datedebut between date_add(?,interval 1 minute) and date_sub(?,interval 1 minute)) or(vt2.datefin between date_add(?,interval 1 minute) and date_sub(?,interval 1 minute) ) 
            or(date_add(?,interval 1 minute) between vt2.datedebut and vt2.datefin) ) 
            and v.numero not in (select numero from entretien as en where ( en.datedebut between ? and ? ) 
            or( en.datefin between ? and ? ) or(? between en.datedebut and en.datefin) ) ) and v.status=1 and vt.depart !=21 )
            as actu
        left join (select la.*,vt.datedebut as dateprochain,dep.nom as departprochain,dep.id as lieuprochain,vt.id as idapres,vt.numero from listeadjacence as la 
        join voituretrajet as vt on la.trajetadj=vt.id 
        join lieu as dep on dep.id=vt.depart 
        join lieu as ar on ar.id=vt.arrive ) as trajetadj on trajetadj.trajet=actu.idavant and trajetadj.numero=actu.numero";

        $query =  $this->db->query($sql, array($datedebut,$datedebut,$datedebut,$datedebut,$datefin,$datedebut,$datefin,$datedebut,$datedebut,$datefin,$datedebut,$datefin,$datedebut));
        return $query->result();
    }



    /**
     * 
     * les voitures assigner à un trajet 
     * 
     */

     public function getVehiculeAssigner($idtrajet)
     {
     	$sql = "SELECT actu.numero, actu.idprestataire, actu.nom as prestataire, actu.chauffeur, req1.id as lastid , actu.idchauffeur,
 req1.datedebut as lastdebut , req1.datefin as lastfin, req1.idcircuit as lastcircuit , req1.depart as lastdepart, req1.arrive as lastarrive,
 req2.datedebut as nextdebut , req2.datefin as nextfin, req2.idcircuit as nextcircuit, req2.depart as nextdepart, req2.arrive as nextarrive,req2.id as nextid
FROM (SELECT numero, idprestataire, t.nom, chauffeur, t.id, datedebut, datefin, idcircuit, idchauffeur,dep.nom as depart,ar.nom as arrive
FROM
	voituretrajet t join lieu as dep on dep.id=t.depart join lieu as ar on ar.id=t.arrive
where t.id in (select trajet from listeadjacence where trajetadj=?) and numero in (select numero from voituretrajet where id=?)) as req1
join (SELECT numero, idprestataire, nom, chauffeur, id, datedebut, datefin, idcircuit, idchauffeur, depart, arrive
FROM
	voituretrajet t where id= ? )as actu on actu.numero = req1.numero
left join (SELECT numero, idprestataire, t.nom, chauffeur, t.id, datedebut, datefin, idcircuit, idchauffeur,dep.nom as depart,ar.nom as arrive
FROM
	voituretrajet t join lieu as dep on dep.id=t.depart join lieu as ar on ar.id=t.arrive where t.id in (select trajetadj from listeadjacence where trajet=?) 
and numero in (select numero from voituretrajet where id=?)) as req2 on req2.numero=actu.numero";

		 $query =  $this->db->query($sql, array($idtrajet,$idtrajet,$idtrajet,$idtrajet,$idtrajet));
		 return $query->result();
     }


    /**
     * les chauffeurs disponibles pour un trajet
     * 
     */

     public function getChauffeurDispo($datedebut,$datefin)
     {
        $sql = "SELECT * from chauffeur where id not in (select idchauffeur from trajetsvoiture as tv join detailcircuit as d on tv.idtrajet = d.id
		where idchauffeur is not null and (
		( d.datedebut between ? and ?) 
		or(d.datefin between ? and ? ) 
		or(? between d.datedebut and d.datefin)
		) ) ";

        $query =  $this->db->query($sql, array($datedebut,$datefin,$datedebut,$datefin,$datedebut));
        return $query->result();
     }

	 /**
	  * list des voitures en attentes
	  */
	  public function getAttente()
	  {
		$sql="SELECT req1.numero, req1.idprestataire, req1.nom, req1.chauffeur, req1.id,req1.idarrive,
		req1.datedebut, req1.datefin, req1.idcircuit, req1.idchauffeur, req1.depart, req1.arrive,req1.client,
	   req2.id as id2
	   from 
	   (
	   select numero, idprestataire, vt.nom, chauffeur, vt.id, vt.datedebut, vt.datefin, idcircuit, idchauffeur,
	   dep.nom as depart,ar.nom as arrive,c.client,vt.arrive as idarrive from voituretrajet as vt
	   join lieu as dep on dep.id=vt.depart
	   join lieu as ar on ar.id=vt.arrive
	   left join listeadjacence as la on vt.id=la.trajet
	   left join circuit as c on c.id=vt.idcircuit
	   )as req1 left join (select * from listeadjacence as lb join voituretrajet as vt2 on lb.trajetadj=vt2.id )as req2 on req2.numero=req1.numero 
	   and req2.trajet=req1.id where req2.id is null and req1.idarrive !=21
	   ";

		$query =  $this->db->query($sql);
		return $query->result();
	  }


     /***
      * assigner une voiture sans trajets precedent et sans trajet prochain
      */
    public function assignSansTrajet($data)
    {
        $this->db->insert('trajetsvoiture',$data);
        
    }


    /**
     * prochain trajet d'une voiture
     */
    public function adjacentApres($numero,$idtrajet)
    {
        $sql= "SELECT avant.numero,avant.idprestataire,avant.nom,avant.chauffeur,avant.idchauffeur,avant.idavant,
		avant.debutavant,avant.finavant,avant.circuitavant,avant.departavant,avant.ldepartavant,avant.arriveavant,
		avant.larriveavant,idapres,debutapres,
		finapres,circuitapres,departapres,ldepartapres,
		arriveapres,larriveapres from
		(
			SELECT vt.numero,vt.idprestataire,vt.nom,vt.chauffeur,vt.idchauffeur,vt.id as idavant,
			vt.datedebut as debutavant,vt.datefin as finavant,vt.idcircuit as circuitavant,
			 vt.depart as departavant,ld.nom as ldepartavant, vt.arrive as arriveavant,ar.nom as larriveavant from voituretrajet as vt 
			join lieu as ld on ld.id = vt.depart 
			join lieu as ar on ar.id = vt.arrive
			where vt.numero = ? and vt.id = ?
		) as avant left join 
		(
			SELECT vt2.id as idapres,vt2.datedebut as debutapres,
			vt2.datefin as finapres,vt2.idcircuit as circuitapres, vt2.depart as departapres,ld1.nom as ldepartapres,
			 vt2.arrive as arriveapres, ar1.nom as larriveapres, la.trajet,vt2.numero
			from voituretrajet as vt2 
			join lieu as ld1 on ld1.id = vt2.depart 
			join lieu as ar1 on ar1.id = vt2.arrive 
			join listeadjacence as la on la.trajetadj=vt2.id
			where vt2.numero = ? and la.trajet = ?
		) as apres on apres.trajet=avant.idavant and apres.numero=avant.numero";

        $query =  $this->db->query($sql, array($numero,$idtrajet,$numero,$idtrajet));

        return $query->result();

    }

    

    /**
     * dernier trajet d'une voiture
     */

    public function adjacentAvant($numero,$idtrajet)
    {
        $sql= "SELECT idavant,debutavant,
		finavant,circuitavant,departavant,ldepartavant,
		arriveavant,larriveavant,apres.numero,apres.idprestataire,apres.nom,apres.chauffeur,apres.idchauffeur,apres.idapres,
		apres.debutapres,apres.finapres,apres.circuitapres,apres.departapres,apres.ldepartapres,apres.arriveapres,
		apres.larriveapres from
		(
			SELECT vt.numero,vt.idprestataire,vt.nom,vt.chauffeur,vt.idchauffeur,vt.id as idapres,
			vt.datedebut as debutapres,vt.datefin as finapres,vt.idcircuit as circuitapres,
			 vt.depart as departapres,ld.nom as ldepartapres, vt.arrive as arriveapres,ar.nom as larriveapres from voituretrajet as vt 
			join lieu as ld on ld.id = vt.depart 
			join lieu as ar on ar.id = vt.arrive
			where vt.numero = ? and  vt.id = ?
		) as apres left join 
		(
			SELECT vt2.id as idavant,vt2.datedebut as debutavant,
			vt2.datefin as finavant,vt2.idcircuit as circuitavant, vt2.depart as departavant,ld1.nom as ldepartavant,
			 vt2.arrive as arriveavant, ar1.nom as larriveavant, la.trajetadj,vt2.numero
			from voituretrajet as vt2 
			join lieu as ld1 on ld1.id = vt2.depart 
			join lieu as ar1 on ar1.id = vt2.arrive 
			join listeadjacence as la on la.trajet=vt2.id
			where vt2.numero = ? and la.trajetadj = ?
		) as avant on avant.trajetadj=apres.idapres and avant.numero=apres.numero";

        $query =  $this->db->query($sql, array($numero,$idtrajet,$numero,$idtrajet));

        return $query->result();

    }


    public function rentrer($data)
	{
		$this->db->trans_Start();
		
		$this->db->where('id', $data['idtrajet']);
		$trajetavant=$this->db->get('detailcircuit')->result();


		$sql = "SELECT * from detailcircuit as c
                    where id in (select trajetadj from listeadjacence where trajet = ? ) 
                    and datedebut = ? and datefin = ? and depart = ? and arrive = 21
                    ";

		$query =  $this->db->query($sql, array($data['idtrajet'],$data['datedepart'] ,$data['datearrive'],$trajetavant[0]->arrive));

		/**
		 * si le trajet existe déja
		 */
		$trajetliaisonExiste = $query->result();
		if(!empty($trajetliaisonExiste))
		{
			$liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
			$liaisonvoiture['numero']=$data['numero'];
			$liaisonvoiture['idchauffeur']=$data['idchauffeur'];
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);
		}
		else
		{
			/**
			 * insertion du trajet de liaison
			 */
			$trajetliaison['datedebut']=$data['datedepart'];
			$trajetliaison['datefin']=$data['datearrive'];
			$trajetliaison['depart']=$trajetavant[0]->arrive;
			$trajetliaison['arrive']=21;
			$trajetliaison['gestiontransport']=null;
			$trajetliaison['place']=null;
			$this->db->insert('detailcircuit',$trajetliaison);
			$id=$this->db->insert_id();
			/**
			 * adjacence de l'ancien trajet
			 */
			$listadjacence['trajet']=$data['idtrajet'];
			$listadjacence['trajetadj']=$id;
			$this->db->insert('listeadjacence', $listadjacence);

			/**
			 * assigner une voiture au trajet de liaison
			 */
			$liaisonvoiture['idtrajet']=$id;
			$liaisonvoiture['numero']=$data['numero'];
			$liaisonvoiture['idchauffeur']=$data['idchauffeur'];
			$liaisonvoiture['idlocation']=$data['idlocation'];
			$this->db->insert('trajetsvoiture',$liaisonvoiture);
		}

		$this->db->trans_Complete();
	}

    /**
	 * inserer un trajet entre deux trajet
	 *
	 */
    public function InsertBetweenTrajet($avant,$apres,$nouveau,$numero,$datefin,$idchauffeur)
	{
        $this->db->trans_begin();

		/**
		 * delete adjacence
		 */
		$this->db->where('trajet',$avant);
		$this->db->where('trajetadj',$apres);
		$this->db->delete('listeadjacence');

        
        $this->db->where('id', $nouveau);
		$trajetnouveau=$this->db->get('detailcircuit')->result();
		$this->db->where('id', $avant);
		$trajetavant=$this->db->get('detailcircuit')->result();
		$this->db->where('id', $apres);
		$trajetapres=$this->db->get('detailcircuit')->result();

		$sql = "SELECT * from detailcircuit as c
            where id in (select trajetadj from listeadjacence where trajet = ? ) 
            and datedebut = ? and datefin = ? and depart = ? and arrive = ?
            ";

		$query =  $this->db->query($sql, array($avant,$trajetavant[0]->datefin,
			$trajetnouveau[0]->datedebut,$trajetavant[0]->arrive,$trajetnouveau[0]->depart));

		/**
		 * si le trajet existe déja
		 */
		$trajetliaisonExiste = $query->result();

		if(!empty($trajetliaisonExiste))
		{
			$liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=$idchauffeur;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);
		}
		else
		{
			/**
			 * insertion du trajet de liaison
			 */
			$trajetliaison['datedebut']=$trajetavant[0]->datefin;
			$trajetliaison['datefin']=$trajetnouveau[0]->datedebut;
			$trajetliaison['depart']=$trajetavant[0]->arrive;
			$trajetliaison['arrive']=$trajetnouveau[0]->depart;
			$trajetliaison['gestiontransport']=null;
			$trajetliaison['place']=null;
			$this->db->insert('detailcircuit',$trajetliaison);
			$id=$this->db->insert_id();

			/**
			 * adjacence du nouveau trajet de liaison
			 */
			$listadjacence['trajet']=$avant;
			$listadjacence['trajetadj']=$id;
			$this->db->insert('listeadjacence', $listadjacence);

			/**
			 * adjacence du trajet actuelle
			 */
			$listadjacence['trajet']=$id;
			$listadjacence['trajetadj']=$nouveau;
			$this->db->insert('listeadjacence', $listadjacence);


			/**
			 * assigner une voiture au trajet de liaison
			 */
			$liaisonvoiture['idtrajet']=$id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=$idchauffeur;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);

		}


			/**
			 * assigner la voiture au trajet actuelle
			 */
			$dataTrajet['idtrajet']=$nouveau;
			$dataTrajet['numero']=$numero;
			$dataTrajet['idchauffeur']=$idchauffeur;
			$dataTrajet['idlocation']=null;
			$this->db->insert('trajetsvoiture',$dataTrajet);


		/**
		 * trajet de liaison vers le prochain trajet
		 */
		$sql = "SELECT * from detailcircuit as c
            where id in (select trajetadj from listeadjacence where trajet = ? ) 
            and datedebut = ? and datefin = ? and depart = ? and arrive = ?
            ";

		$query =  $this->db->query($sql, array($nouveau,$trajetnouveau[0]->datefin,
			$datefin,$trajetnouveau[0]->arrive,21));

		/**
		 * si le trajet existe déja
		 */
		$trajetliaisonExiste = $query->result();

		if(!empty($trajetliaisonExiste))
		{
			$liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=$idchauffeur;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);
		}
		else
		{
			/**
			 * insertion du trajet de liaison
			 */
			$trajetliaison['datedebut']=$trajetnouveau[0]->datefin;
			$trajetliaison['datefin']=$datefin;
			$trajetliaison['depart']=$trajetnouveau[0]->arrive;
			$trajetliaison['arrive']=21;
			$trajetliaison['gestiontransport']=null;
			$trajetliaison['place']=null;
			$this->db->insert('detailcircuit',$trajetliaison);
			$id=$this->db->insert_id();

			/**
			 * adjacence du nouveau trajet de liaison
			 */
			$listadjacence['trajet']=$nouveau;
			$listadjacence['trajetadj']=$id;
			$this->db->insert('listeadjacence', $listadjacence);

			/**
			 * adjacence du trajet actuelle
			 */
			$listadjacence['trajet']=$id;
			$listadjacence['trajetadj']=$apres;
			$this->db->insert('listeadjacence', $listadjacence);


			/**
			 * assigner une voiture au trajet de liaison
			 */
			$liaisonvoiture['idtrajet']=$id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=$idchauffeur;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);

		}

		$this->db->trans_Complete();
	}

    /**
     * assigner une voiture à un trajet
     */
    public function assignVoiture($dataTrajet,$data)
    {

       /**
         *  cas 1
         *  pas de trajet avant et apres
         *
         */
        if(empty($data['idavant']) && empty($data['idsuivant'])  )
        {
            $this->db->trans_Start();

			
            //nouveau trajet du Parking vers la region de départ
            $trajetliaison['idcircuit']=null;
            $trajetliaison['datedebut']=$data['datedepart'];
            $trajetliaison['datefin']=$data['datedebut'];
            $trajetliaison['depart']=21;
            $trajetliaison['arrive']=$data['lieuactuelle'];
            $trajetliaison['gestiontransport']=null;
            $trajetliaison['place']=null;
            $this->db->insert('detailcircuit',$trajetliaison);
            $id=$this->db->insert_id();


            /**
             * adjacence du trajet de liaison
             */
            $listadjacence['trajet']=$id;
            $listadjacence['trajetadj']=$data['idactuelle'];
            $this->db->insert('listeadjacence', $listadjacence);


            /**
             * assigner la voiture au trajet de liaison
             */
            $liaisonvoiture['idtrajet']=$id;
            $liaisonvoiture['numero']=$dataTrajet['numero'];
            $liaisonvoiture['idchauffeur']=$dataTrajet['idchauffeur'];
            $liaisonvoiture['idlocation']=$dataTrajet['idlocation'];
            $this->db->insert('trajetsvoiture',$liaisonvoiture);

            /**
             * assigner la voiture au trajet actuelle
             */
            $this->db->insert('trajetsvoiture',$dataTrajet);

            $this->db->trans_complete();
        }


        /**
         * cas 2
         * trajet avec avant et avec trajet après
         *
         */


         /**
         * cas 3
         * trajet avec avant et sans après
         */

        if(empty($data['idavant'])==false && empty($data['idsuivant']))
        {


            /**
             *  si la dernière région  est la même que celui du trajet
             */
            if($data['lieuactuelle'] == $data['lieuavant'])
            {
                $this->db->trans_Start();
					$this->db->where('trajet',$data['idavant']);
					$this->db->where('trajetadj',$data['idactuelle']);
					$adj=$this->db->get('listeadjacence')->result();
					if(empty($adj))
					{
						//ce trajet doit être adjacent au nouveau trajet
						$listadjacence['trajet']=$data['idavant'];
						$listadjacence['trajetadj']=$data['idactuelle'];
						$this->db->insert('listeadjacence', $listadjacence);
					}
					else
					{

					}
                    
                    /**
                     * assigner la voiture au trajet actuelle
                    */
                    $this->db->insert('trajetsvoiture',$dataTrajet);
                $this->db->trans_Complete();
            }
            else
            {
                $this->db->trans_Start();
                    $this->db->where('id', $data['idavant']);
                    $trajetavant=$this->db->get('detailcircuit')->result();
                    $this->db->where('id', $data['idactuelle']);
                    $trajetapres=$this->db->get('detailcircuit')->result();

					$datedeb=$trajetavant[0]->datefin;
                    if(!empty($data['datedepart']))
					{
						$datedeb=$data['datedepart'];
					}

                    $sql = "SELECT * from detailcircuit as c
                    where id in (select trajet from listeadjacence where trajetadj = ? ) 
                    and datedebut = ? and datefin = ? and depart = ? and arrive = ?
                    ";

                    $query =  $this->db->query($sql, array($data['idactuelle'],$datedeb ,$trajetapres[0]->datedebut,$trajetavant[0]->arrive,$trajetapres[0]->depart));

                    /**
                     * si le trajet existe déja
                     */
                    $trajetliaisonExiste = $query->result();

                    if(!empty($trajetliaisonExiste))
                    {
                        $liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
                        $liaisonvoiture['numero']=$dataTrajet['numero'];
                        $liaisonvoiture['idchauffeur']=$dataTrajet['idchauffeur'];
                        $liaisonvoiture['idlocation']=$dataTrajet['idlocation'];
                        $this->db->insert('trajetsvoiture',$liaisonvoiture);
                    }
                    else
                    {
                        /**
                         * insertion du trajet de liaison
                         */
                        $trajetliaison['datedebut']=$datedeb;
                        $trajetliaison['datefin']=$trajetapres[0]->datedebut;
                        $trajetliaison['depart']=$trajetavant[0]->arrive;
                        $trajetliaison['arrive']=$trajetapres[0]->depart;
                        $trajetliaison['gestiontransport']=null;
                        $trajetliaison['place']=null;
                        $this->db->insert('detailcircuit',$trajetliaison);
                        $id=$this->db->insert_id();
						/**
						 * adjacence de l'ancien trajet
						 */
						$listadjacence['trajet']=$data['idavant'];
						$listadjacence['trajetadj']=$id;
						$this->db->insert('listeadjacence', $listadjacence);

                        /**
                         * adjacence du trajet de liaison
                         */
                        $listadjacence['trajet']=$id;
                        $listadjacence['trajetadj']=$data['idactuelle'];
                        $this->db->insert('listeadjacence', $listadjacence);
                        /**
                         * assigner une voiture au trajet de liaison
                         */
                        $liaisonvoiture['idtrajet']=$id;
                        $liaisonvoiture['numero']=$dataTrajet['numero'];
                        $liaisonvoiture['idchauffeur']=$dataTrajet['idchauffeur'];
                        $liaisonvoiture['idlocation']=$dataTrajet['idlocation'];
                        $this->db->insert('trajetsvoiture',$liaisonvoiture);
                    }


                    /**
                     * assigner la voiture au trajet actuelle
                     */
                    $this->db->insert('trajetsvoiture',$dataTrajet);

                $this->db->trans_Complete();
            }


        }

        /**
         * cas 4
         * trajet avec apres et avec avant
         *
         */
        if(empty($data['idavant'])==false && empty($data['idsuivant'])==false)
        {
            $this->InsertBetweenTrajet($data['idavant'],$data['idsuivant'],$data['idactuelle'],$dataTrajet['numero'],$data['datefin'],$dataTrajet['idchauffeur']);
        }

    }

    /**
     * supprimer le trajet de liaison entre deux trajets
     */
    public function supprliaison($remplacer,$numero)
    {
        /**
		 * vérifier si le trajet contient plusieur voiture
		 */

		$sql1 = "SELECT count(*) as nbr from voituretrajet where id=? ";

		$query =  $this->db->query($sql1, array($remplacer));
		$nbrvoiture=$query->result()[0]->nbr;
		if($nbrvoiture>1)
		{
			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $remplacer);
			$this->db->where('numero', $numero);
			$this->db->delete('trajetsvoiture');
		}
		else
		{

			/**
			 * delete adjacence
			 */
			$this->db->where('trajetadj',$remplacer);
			$this->db->delete('listeadjacence');
			$this->db->where('trajet',$remplacer);
			$this->db->delete('listeadjacence');

			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $remplacer);
			$this->db->where('numero', $numero);
			$this->db->delete('trajetsvoiture');

			/**
			 * delete trajet de retour
			 */
			$this->db->select('idcircuit');
			$this->db->where('id',$remplacer);
			$dc=$this->db->get('detailcircuit')->result();
			$idcircuit=$dc[0]->idcircuit;

			if(empty($idcircuit))
			{
				$this->db->where('id',$remplacer);
				$this->db->delete('detailcircuit');
			}


		}
    }

	


	/***
	 * enlever un trajet et le remplacer par un nouveau
	 */
    public function ChangementTrajet($avant,$remplacer,$apres,$nouveau,$numero)
	{
		$this->db->trans_start();

		/**
		 * vérifier si le trajet contient plusieur voiture
		 */

		$sql1 = "SELECT count(*) as nbr from voituretrajet where id=? ";

		$query =  $this->db->query($sql1, array($remplacer));
		$nbrvoiture=$query->result()[0]->nbr;
		if($nbrvoiture>1)
		{
			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $remplacer);
			$this->db->where('numero', $numero);
			$this->db->delete('trajetsvoiture');
		}
		else
		{
			/**
			 * delete adjacence
			 */
			$this->db->where('trajetadj',$remplacer);
			$this->db->delete('listeadjacence');
			$this->db->where('trajet',$remplacer);
			$this->db->delete('listeadjacence');

			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $remplacer);
			$this->db->where('numero', $numero);
			$this->db->delete('trajetsvoiture');

			/**
			 * delete trajet de retour
			 */
			$this->db->where('id',$remplacer);
			$this->db->delete('detailcircuit');
		}

		$this->db->where('id', $nouveau);
		$trajetnouveau=$this->db->get('detailcircuit')->result();
		$this->db->where('id', $avant);
		$trajetavant=$this->db->get('detailcircuit')->result();
		$this->db->where('id', $apres);
		$trajetapres=$this->db->get('detailcircuit')->result();

		$sql = "SELECT * from detailcircuit as c
            where id in (select trajetadj from listeadjacence where trajet = ? ) 
            and datedebut = ? and datefin = ? and depart = ? and arrive = ?
            ";

		$query =  $this->db->query($sql, array($avant,$trajetavant[0]->datefin,
			$trajetnouveau[0]->datedebut,$trajetavant[0]->arrive,$trajetnouveau[0]->depart));

		/**
		 * si le trajet existe déja
		 */
		$trajetliaisonExiste = $query->result();

		if(!empty($trajetliaisonExiste))
		{
			$liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=null;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);
		}
		else
		{
			/**
			 * insertion du trajet de liaison
			 */
			$trajetliaison['datedebut']=$trajetavant[0]->datefin;
			$trajetliaison['datefin']=$trajetnouveau[0]->datedebut;
			$trajetliaison['depart']=$trajetavant[0]->arrive;
			$trajetliaison['arrive']=$trajetnouveau[0]->depart;
			$trajetliaison['gestiontransport']=null;
			$trajetliaison['place']=null;
			$this->db->insert('detailcircuit',$trajetliaison);
			$id=$this->db->insert_id();

			/**
			 * adjacence du nouveau trajet de liaison
			 */
			$listadjacence['trajet']=$avant;
			$listadjacence['trajetadj']=$id;
			$this->db->insert('listeadjacence', $listadjacence);

			/**
			 * adjacence du trajet actuelle
			 */
			$listadjacence['trajet']=$id;
			$listadjacence['trajetadj']=$nouveau;
			$this->db->insert('listeadjacence', $listadjacence);


			/**
			 * assigner une voiture au trajet de liaison
			 */
			$liaisonvoiture['idtrajet']=$id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=null;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);

		}


			/**
			 * assigner la voiture au trajet actuelle
			 */
			$dataTrajet['idtrajet']=$nouveau;
			$dataTrajet['numero']=$numero;
			$dataTrajet['idchauffeur']=null;
			$dataTrajet['idlocation']=null;
			$this->db->insert('trajetsvoiture',$dataTrajet);


		/**
		 * trajet de liaison vers le prochain trajet
		 */
		$sql = "SELECT * from detailcircuit as c
            where id in (select trajetadj from listeadjacence where trajet = ? ) 
            and datedebut = ? and datefin = ? and depart = ? and arrive = ?
            ";

		$query =  $this->db->query($sql, array($nouveau,$trajetnouveau[0]->datefin,
			$trajetapres[0]->datedebut,$trajetnouveau[0]->arrive,$trajetapres[0]->depart));

		/**
		 * si le trajet existe déja
		 */
		$trajetliaisonExiste = $query->result();

		if(!empty($trajetliaisonExiste))
		{
			$liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=null;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);
		}
		else
		{
			/**
			 * insertion du trajet de liaison
			 */
			$trajetliaison['datedebut']=$trajetnouveau[0]->datefin;
			$trajetliaison['datefin']=$trajetapres[0]->datedebut;
			$trajetliaison['depart']=$trajetnouveau[0]->arrive;
			$trajetliaison['arrive']=$trajetapres[0]->depart;
			$trajetliaison['gestiontransport']=null;
			$trajetliaison['place']=null;
			$this->db->insert('detailcircuit',$trajetliaison);
			$id=$this->db->insert_id();

			/**
			 * adjacence du nouveau trajet de liaison
			 */
			$listadjacence['trajet']=$nouveau;
			$listadjacence['trajetadj']=$id;
			$this->db->insert('listeadjacence', $listadjacence);

			/**
			 * adjacence du trajet actuelle
			 */
			$listadjacence['trajet']=$id;
			$listadjacence['trajetadj']=$apres;
			$this->db->insert('listeadjacence', $listadjacence);


			/**
			 * assigner une voiture au trajet de liaison
			 */
			$liaisonvoiture['idtrajet']=$id;
			$liaisonvoiture['numero']=$numero;
			$liaisonvoiture['idchauffeur']=null;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);

		}

		$this->db->trans_Complete();
	}


    public function assignVoitureavide($dataTrajet,$data)
    {
            /**
             * rechercher le trajet avant le trajet à vide
             */
            $sql = "SELECT d.*,la.trajetadj,numero from detailcircuit as d 
            join listeadjacence as la 
                on la.trajet = d.id
            join trajetsvoiture as tv
                on tv.idtrajet = la.trajetadj where trajetadj=? and numero=? ";

            $query =  $this->db->query($sql, array($data['idavant'],$dataTrajet['numero']));
            $trajetavant=$query->result();
            $this->db->trans_start();

            /**
             * vérifier si le trajet contient plusieur voiture
             */

            $sql1 = "SELECT count(*) as nbr from voituretrajet where id=? ";

            $query =  $this->db->query($sql1, array($data['idavant']));
            $nbrvoiture=$query->result()[0]->nbr;
            if($nbrvoiture>1)
            {
                /**
                 * enlever la voiture du trajet
                 */
                $this->db->where('idtrajet', $data['idavant']);
                $this->db->where('numero', $dataTrajet['numero']);
                $this->db->delete('trajetsvoiture');
            }
            else
            {
                /**
                 * delete adjacence
                 */
                $this->db->where('trajetadj',$data['idavant']);
                $this->db->delete('listeadjacence');

                /**
                 * enlever la voiture du trajet
                 */
                $this->db->where('idtrajet', $data['idavant']);
                $this->db->where('numero', $dataTrajet['numero']);
                $this->db->delete('trajetsvoiture');

                /**
                 * delete trajet de retour
                 */
                $this->db->where('id',$data['idavant']);
                $this->db->delete('detailcircuit');
            }

            $this->db->where('id', $data['idactuelle']);
            $trajetapres=$this->db->get('detailcircuit')->result();


            $sql = "SELECT * from detailcircuit as c
            where id in (select trajet from listeadjacence where trajetadj = ? ) 
            and datedebut = ? and datefin = ? and depart = ? and arrive = ?
            ";

            $query =  $this->db->query($sql, array($data['idactuelle'], $trajetavant[0]->datefin,$trajetapres[0]->datedebut,$trajetavant[0]->arrive,$trajetapres[0]->depart));
            
            /**
             * si le trajet existe déja
             */
            $trajetliaisonExiste = $query->result();

            if(!empty($trajetliaisonExiste))
            {
                $liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
                $liaisonvoiture['numero']=$dataTrajet['numero'];
                $liaisonvoiture['idchauffeur']=null;
                $liaisonvoiture['idlocation']=$dataTrajet['idlocation'];
                $this->db->insert('trajetsvoiture',$liaisonvoiture);
            }
            else
            {
                /**
                 * insertion du trajet de liaison
                 */
                $trajetliaison['datedebut']=$trajetavant[0]->datefin;
                $trajetliaison['datefin']=$trajetapres[0]->datedebut;
                $trajetliaison['depart']=$trajetavant[0]->arrive;
                $trajetliaison['arrive']=$trajetapres[0]->depart;
                $trajetliaison['gestiontransport']=null;
                $trajetliaison['place']=null;
                $this->db->insert('detailcircuit',$trajetliaison);
                $id=$this->db->insert_id();

                /**
                 * adjacence du nouveau trajet de liaison 
                 */
                $listadjacence['trajet']=$trajetavant[0]->id;
                $listadjacence['trajetadj']=$id;
                $this->db->insert('listeadjacence', $listadjacence);

                /**
                 * adjacence du trajet actuelle
                 */
                $listadjacence['trajet']=$id;
                $listadjacence['trajetadj']=$data['idactuelle'];
                $this->db->insert('listeadjacence', $listadjacence);
                

                /**
                 * assigner une voiture au trajet de liaison
                 */
                $liaisonvoiture['idtrajet']=$id;
                $liaisonvoiture['numero']=$dataTrajet['numero'];
                $liaisonvoiture['idchauffeur']=null;
                $liaisonvoiture['idlocation']=$dataTrajet['idlocation'];
                $this->db->insert('trajetsvoiture',$liaisonvoiture);

            }

            /**
             * assigner la voiture au trajet actuelle
             */
            $this->db->insert('trajetsvoiture',$dataTrajet);
            

        $this->db->trans_Complete();
        
    }

	/**
	 * les trajets du types Lieu ---> Parking ---> Parking ---->Lieu
	 */
	public function assignSansParking($data)
	{
		/**
		 * enlever le trajet retour du trajet avant actuelle et garder celui après
		 *
		 * lieu ----> trajetactuelle ----> Parking ----> prochain trajet
		 */
		if($data['avideparking']=='cas1')
		{
			$this->ChangementTrajet($data['idavant'],$data['idavantP1'],$data['idapresP1'],$data['idtrajet'],$data['numero']);
		}
		elseif ($data['avideparking']=='cas2')
		{
			//ChangementTrajet($avant,$remplacer,$apres,$nouveau,$numero)
			$this->ChangementTrajet($data['idavantP1'],$data['idapresP1'],$data['idapres'],$data['idtrajet'],$data['numero']);
		}
		else
		{
			//supprimer les deux trajets parking et joindre les deux trajets au nouveau
			$this->db->trans_start();

			/**
			 * vérifier si les trajets parking contient plusieurs voitures
			 */
			$sql1 = "SELECT count(*) as nbr from voituretrajet where id=? ";

			$query =  $this->db->query($sql1, array($data['idavantP1']));
			$nbrvoiture=$query->result()[0]->nbr;
			if($nbrvoiture>1)
			{
				/**
				 * enlever la voiture du trajet
				 */
				$this->db->where('idtrajet', $data['idavantP1']);
				$this->db->where('numero', $data['numero']);
				$this->db->delete('trajetsvoiture');
			}
			else
			{
				/**
				 * delete adjacence
				 */
				$this->db->where('trajetadj',$data['idavantP1']);
				$this->db->delete('listeadjacence');
				$this->db->where('trajet',$data['idavantP1']);
				$this->db->delete('listeadjacence');

				/**
				 * enlever la voiture du trajet
				 */
				$this->db->where('idtrajet', $data['idavantP1']);
				$this->db->where('numero', $data['numero']);
				$this->db->delete('trajetsvoiture');

				/**
				 * delete trajet de retour
				 */
				$this->db->where('id',$data['idavantP1']);
				$this->db->delete('detailcircuit');
			}

			$sql1 = "SELECT count(*) as nbr from voituretrajet where id=? ";

			$query =  $this->db->query($sql1, array($data['idapresP1']));
			$nbrvoiture=$query->result()[0]->nbr;
			if($nbrvoiture>1)
			{
				/**
				 * enlever la voiture du trajet
				 */
				$this->db->where('idtrajet', $data['idapresP1']);
				$this->db->where('numero', $data['numero']);
				$this->db->delete('trajetsvoiture');
			}
			else
			{
				/**
				 * delete adjacence
				 */
				$this->db->where('trajetadj',$data['idapresP1']);
				$this->db->delete('listeadjacence');
				$this->db->where('trajet',$data['idapresP1']);
				$this->db->delete('listeadjacence');

				/**
				 * enlever la voiture du trajet
				 */
				$this->db->where('idtrajet', $data['idapresP1']);
				$this->db->where('numero', $data['numero']);
				$this->db->delete('trajetsvoiture');

				/**
				 * delete trajet de retour
				 */
				$this->db->where('id',$data['idapresP1']);
				$this->db->delete('detailcircuit');
			}

			$this->db->where('id', $data['idtrajet']);
			$trajetnouveau=$this->db->get('detailcircuit')->result();
			$this->db->where('id', $data['idavant']);
			$trajetavant=$this->db->get('detailcircuit')->result();
			$this->db->where('id', $data['idapres']);
			$trajetapres=$this->db->get('detailcircuit')->result();

			$sql = "SELECT * from detailcircuit as c
            where id in (select trajetadj from listeadjacence where trajet = ? ) 
            and datedebut = ? and datefin = ? and depart = ? and arrive = ?
            ";

			$query =  $this->db->query($sql, array($trajetavant[0]->id,$trajetavant[0]->datefin,
				$trajetnouveau[0]->datedebut,$trajetavant[0]->arrive,$trajetnouveau[0]->depart));

			/**
			 * si le trajet existe déja
			 */
			$trajetliaisonExiste = $query->result();

			if(!empty($trajetliaisonExiste))
			{
				$liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=null;
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);
			}
			else
			{
				/**
				 * insertion du trajet de liaison
				 */
				$trajetliaison['datedebut']=$trajetavant[0]->datefin;
				$trajetliaison['datefin']=$trajetnouveau[0]->datedebut;
				$trajetliaison['depart']=$trajetavant[0]->arrive;
				$trajetliaison['arrive']=$trajetnouveau[0]->depart;
				$trajetliaison['gestiontransport']=null;
				$trajetliaison['place']=null;
				$this->db->insert('detailcircuit',$trajetliaison);
				$id=$this->db->insert_id();

				/**
				 * adjacence du nouveau trajet de liaison
				 */
				$listadjacence['trajet']=$trajetavant[0]->id;
				$listadjacence['trajetadj']=$id;
				$this->db->insert('listeadjacence', $listadjacence);

				/**
				 * adjacence du trajet actuelle
				 */
				$listadjacence['trajet']=$id;
				$listadjacence['trajetadj']=$trajetnouveau[0]->id;
				$this->db->insert('listeadjacence', $listadjacence);


				/**
				 * assigner une voiture au trajet de liaison
				 */
				$liaisonvoiture['idtrajet']=$id;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=null;
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);

			}


			/**
			 * assigner la voiture au trajet actuelle
			 */
			$dataTrajet['idtrajet']=$trajetnouveau[0]->id;
			$dataTrajet['numero']=$data['numero'];
			$dataTrajet['idchauffeur']=null;
			$dataTrajet['idlocation']=null;
			$this->db->insert('trajetsvoiture',$dataTrajet);


			/**
			 * trajet de liaison vers le prochain trajet
			 */
			$sql = "SELECT * from detailcircuit as c
            where id in (select trajetadj from listeadjacence where trajet = ? ) 
            and datedebut = ? and datefin = ? and depart = ? and arrive = ?
            ";

			$query =  $this->db->query($sql, array($nouveau,$trajetnouveau[0]->datefin,
				$trajetapres[0]->datedebut,$trajetnouveau[0]->arrive,$trajetapres[0]->depart));

			/**
			 * si le trajet existe déja
			 */
			$trajetliaisonExiste = $query->result();

			if(!empty($trajetliaisonExiste))
			{
				$liaisonvoiture['idtrajet']=$trajetliaisonExiste[0]->id;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=null;
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);
			}
			else
			{
				/**
				 * insertion du trajet de liaison
				 */
				$trajetliaison['datedebut']=$trajetnouveau[0]->datefin;
				$trajetliaison['datefin']=$trajetapres[0]->datedebut;
				$trajetliaison['depart']=$trajetnouveau[0]->arrive;
				$trajetliaison['arrive']=$trajetapres[0]->depart;
				$trajetliaison['gestiontransport']=null;
				$trajetliaison['place']=null;
				$this->db->insert('detailcircuit',$trajetliaison);
				$id=$this->db->insert_id();

				/**
				 * adjacence du nouveau trajet de liaison
				 */
				$listadjacence['trajet']=$trajetnouveau[0]->id;
				$listadjacence['trajetadj']=$id;
				$this->db->insert('listeadjacence', $listadjacence);

				/**
				 * adjacence du trajet actuelle
				 */
				$listadjacence['trajet']=$id;
				$listadjacence['trajetadj']=$trajetapres[0]->id;
				$this->db->insert('listeadjacence', $listadjacence);


				/**
				 * assigner une voiture au trajet de liaison
				 */
				$liaisonvoiture['idtrajet']=$id;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=null;
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);

			}
			$this->db->trans_complete();

		}
	}

	/**
	 * enlever une voiture d'un trajet avec apres
	 */
	public function enleverapres($data)
	{
		$this->db->trans_begin();
		if($data['suppression']=='cas1')
		{
			
			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $data['idtrajetactu']);
			$this->db->where('numero', $data['numero']);
			$this->db->delete('trajetsvoiture');

			$this->supprliaison($data['idtrajetavant'],$data['numero']);

			if(!empty($data['liaison']))
			{
				$this->supprliaison($data['liaison'],$data['numero']);
				
			}

			/*
			 * si il y a encore un trajet principal suite au trajet actuelle
			 */
			if(!empty($data['dernierlieu']))
			{
				/**
				 * insertion du trajet de liaison
				 */
				$trajetliaison['datedebut']=$data['depart'];
				$trajetliaison['datefin']=$data['arrive'];
				$trajetliaison['depart']=$data['lieudepart'];
				$trajetliaison['arrive']=$data['lieuarrive'];
				$trajetliaison['gestiontransport']=null;
				$trajetliaison['place']=null;
				$this->db->insert('detailcircuit',$trajetliaison);
				$id=$this->db->insert_id();

				/**
				 * adjacence du nouveau trajet de liaison
				 */
				$listadjacence['trajet']=$id;
				$listadjacence['trajetadj']=$data['iddernierlieu'];
				$this->db->insert('listeadjacence', $listadjacence);

				/**
				 * assigner une voiture au trajet de liaison
				 */
				$liaisonvoiture['idtrajet']=$id;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=$data['idchauffeur'];
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);

			}

		}
		elseif($data['suppression']=='cas2')
		{
			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $data['idtrajetactu']);
			$this->db->where('numero', $data['numero']);
			$this->db->delete('trajetsvoiture');

		
			$this->supprliaison($data['idtrajetavant'],$data['numero']);

			if(!empty($data['liaison']))
			{
				$this->supprliaison($data['liaison'],$data['numero']);
			}

			if(!empty($data['depart']))
			{
					/**
				 * insertion du trajet de liaison
				 */
				$trajetliaison['datedebut']=$data['depart'];
				$trajetliaison['datefin']=$data['arrive'];
				$trajetliaison['depart']=$data['lieudepart'];
				$trajetliaison['arrive']=$data['lieuarrive'];
				$trajetliaison['gestiontransport']=null;
				$trajetliaison['place']=null;
				$this->db->insert('detailcircuit',$trajetliaison);
				$id=$this->db->insert_id();

				/**
				 * assigner une voiture au trajet de liaison
				 */
				$liaisonvoiture['idtrajet']=$id;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=null;
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);


				/**
				 * adjacence du nouveau trajet de liaison
				 */
				$listadjacence['trajet']=$data['adjavant'];
				$listadjacence['trajetadj']=$id;
				$this->db->insert('listeadjacence', $listadjacence);

				/**
				 * adjacence du nouveau trajet de liaison
				 */
				$listadjacence['trajet']=$id;
				$listadjacence['trajetadj']=$data['iddernierlieu'];
				$this->db->insert('listeadjacence', $listadjacence);


			}
			else
			{
				/**
				 * adjacence du nouveau trajet de liaison
				 */
				if(!empty($data['iddernierlieu']))
				{
					$listadjacence['trajet']=$data['adjavant'];
					$listadjacence['trajetadj']=$data['iddernierlieu'];
					$this->db->insert('listeadjacence', $listadjacence);
				}

			}

			
		}
		elseif($data['suppression']=='cas3-1')
		{
			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $data['idtrajetactu']);
			$this->db->where('numero', $data['numero']);
			$this->db->delete('trajetsvoiture');

			/**
			 * à supprimer
			 */
			if(!empty($data['liaisonavant']))
			{
				$this->supprliaison($data['liaisonavant'],$data['numero']);
			}

			

			if(!empty($data['idregiondepart1']))
			{
				/**
			 * nouveaux trajets
			 */

				/**
				 * insertion du trajet de liaison Lieuavant --> Park
				 */
				$trajetliaison['datedebut']=$data['datedebut1'];
				$trajetliaison['datefin']=$data['datearrive1'];
				$trajetliaison['depart']=$data['idregiondepart1'];
				$trajetliaison['arrive']=21;
				$trajetliaison['gestiontransport']=null;
				$trajetliaison['place']=null;
				$this->db->insert('detailcircuit',$trajetliaison);
				$id=$this->db->insert_id();

				/**
				 * assigner une voiture au trajet de liaison
				 */
				$liaisonvoiture['idtrajet']=$id;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=null;
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);

				/**
				 * adjacence du nouveau trajet de liaison
				 */
				$listadjacence['trajet']=$data['adjavant'];
				$listadjacence['trajetadj']=$id;
				$this->db->insert('listeadjacence', $listadjacence);

				/**
				 * insertion du trajet de liaison   Park --> Lieuapres
				 */
				$trajetliaison['datedebut']=$data['datedepart2'];
				$trajetliaison['datefin']=$data['datearrive2'];
				$trajetliaison['depart']=21;
				$trajetliaison['arrive']=$data['idregionarrive2'];
				$trajetliaison['gestiontransport']=null;
				$trajetliaison['place']=null;
				$this->db->insert('detailcircuit',$trajetliaison);
				$id2=$this->db->insert_id();

				/**
				 * assigner une voiture au trajet de liaison
				 */
				$liaisonvoiture['idtrajet']=$id2;
				$liaisonvoiture['numero']=$data['numero'];
				$liaisonvoiture['idchauffeur']=null;
				$liaisonvoiture['idlocation']=null;
				$this->db->insert('trajetsvoiture',$liaisonvoiture);

				/**
				 * adjacence du nouveau trajet de liaison
				 */
				$listadjacence['trajet']=$id;
				$listadjacence['trajetadj']=$id2;
				$this->db->insert('listeadjacence', $listadjacence);


				$listadjacence['trajet']=$id2;
				$listadjacence['trajetadj']=$data['idderniertrajet2'];
				$this->db->insert('listeadjacence', $listadjacence);
			}

			if(!empty($data['idtrajetliaison2']))
			{
				$this->supprliaison($data['idtrajetliaison2'],$data['numero']);
			}
			

		}
		elseif($data['suppression']=='cas3-2')
		{
			/**
			 * enlever la voiture du trajet
			 */
			$this->db->where('idtrajet', $data['idtrajetactu']);
			$this->db->where('numero', $data['numero']);
			$this->db->delete('trajetsvoiture');

			/**
			 * à supprimer
			 */
			if(!empty($data['liaisonavant']))
			{
				$this->supprliaison($data['liaisonavant'],$data['numero']);
			}

			/**
			 * insertion du trajet de liaison Lieuavant --> Park
			 */
			$trajetliaison['datedebut']=$data['datedepart'];
			$trajetliaison['datefin']=$data['datefinarrive'];
			$trajetliaison['depart']=$data['idregiondepart'];
			$trajetliaison['arrive']=$data['idregionarrive'];
			$trajetliaison['gestiontransport']=null;
			$trajetliaison['place']=null;
			$this->db->insert('detailcircuit',$trajetliaison);
			$id=$this->db->insert_id();

			/**
			 * assigner une voiture au trajet de liaison
			 */
			$liaisonvoiture['idtrajet']=$id;
			$liaisonvoiture['numero']=$data['numero'];
			$liaisonvoiture['idchauffeur']=null;
			$liaisonvoiture['idlocation']=null;
			$this->db->insert('trajetsvoiture',$liaisonvoiture);

			/**
			 * adjacence du nouveau trajet de liaison
			 */
			$listadjacence['trajet']=$data['adjavant'];
			$listadjacence['trajetadj']=$id;
			$this->db->insert('listeadjacence', $listadjacence);

			/**
			 * adjacence du nouveau trajet de liaison
			 */
			$listadjacence['trajet']=$id;
			$listadjacence['trajetadj']=$data['idderniertrajet'];
			$this->db->insert('listeadjacence', $listadjacence);

			if(!empty($data['idtrajetliaison']))
			{
				$this->supprliaison($data['idtrajetliaison'],$data['numero']);
			}

		}
		$this->db->trans_complete();
	}

	/**
	 * requête pour inserer une voiture à des trajets adjacent
	 */
	public function AssignMultiVoiture($numero,$datedebut,$datefin,$idcircuit)
	{
		$sql="INSERT INTO trajetsvoiture ( idtrajet, numero, idchauffeur, idlocation)
		SELECT (id),?,null,null FROM detailcircuit as d
		WHERE datedebut > ? and datedebut <= ? and idcircuit = ? ";
		$query=$this->db->query($sql, array($numero,$datedebut,$datefin,$idcircuit));

	}
	/**
	 * assigner une voiture à plusieur trajet
	 */
	public function assignToMulti($dataTrajet,$data)
	{
		$this->db->trans_begin();
			if(empty($data['idsuivant']))
			{
				$data['idactuelle']=$data['iddebut'];
				$data['datedebut']=$data['datedebut1'];
				$data['datefin']=$data['datefin1'];
				$this->assignVoiture($dataTrajet,$data);
				$this->AssignMultiVoiture($dataTrajet['numero'],$data['datedebut1'],$data['datedebut2'],$data['idcircuit']);
			}
			else
			{
				$idsuivant=$data['idsuivant'];
				$data['idsuivant']=null;
				$data['idactuelle']=$data['iddebut'];
				$this->assignVoiture($dataTrajet,$data);
			}

		$this->db->trans_complete();
	}


	/**
	 * enlever une voiture d'un trajet
	 */
	public function enlever($idavant,$idactu,$idapres,$numero)
	{
		
		
		if(empty($idapres))
		{
			$this->db->trans_begin();
			$sql2="SELECT count(*) as nbr from voituretrajet where id=? ";
			$query2 =  $this->db->query($sql2, array($idavant));
			$nbrvoiture=$query2->result()[0]->nbr;
			$this->db->where('id',$idavant);
			$trajetavant=$this->db->get('detailcircuit')->result();
            if($nbrvoiture>1)
            {
				if(empty($trajetavant[0]->idcircuit) )
				{
						/**
					 * enlever la voiture du trajet
					 */
					$this->db->where('idtrajet',$idavant );
					$this->db->where('numero', $numero);
					$this->db->delete('trajetsvoiture');
					/**
					 * 
					 */
					$this->db->where('idtrajet',$idactu);
					$this->db->where('numero', $numero);
					$this->db->delete('trajetsvoiture');
				}else
				{
					/**
					 * 
					 */
					$this->db->where('idtrajet',$idactu);
					$this->db->where('numero', $numero);
					$this->db->delete('trajetsvoiture');
				}
                
            }
			elseif($nbrvoiture==0)
			{
				return -1;
			}
            else
            {
                
				if(empty($trajetavant[0]->idcircuit) )
				{
					/**
					 * delete adjacence
					 */
					$this->db->where('trajetadj',$idavant);
					$this->db->delete('listeadjacence');
					$this->db->where('trajet',$idavant);
					$this->db->delete('listeadjacence');
					/**
					 * enlever la voiture du trajet
					 */
					$this->db->where('idtrajet',$idavant );
					$this->db->where('numero', $numero);
					$this->db->delete('trajetsvoiture');

					/**
					 * delete trajet de liaison
					 */
					$this->db->where('id',$idavant);
					$this->db->delete('detailcircuit');
				}
                
				/**
				 * enlever la voiture du trajet
				 */
				$this->db->where('idtrajet',$idactu);
                $this->db->where('numero', $numero);
                $this->db->delete('trajetsvoiture');
            }
			$sqldelete="SELECT id FROM detailcircuit where arrive=depart and datedebut=datefin 
			and id not in (SELECT trajet FROM listeadjacence)";
			$delete=$this->db->query($sqldelete)->result();

			/**
			 * 
			 */
			$this->db->where('idtrajet',$delete[0]->id);
			$this->db->where('numero', $numero);
			$this->db->delete('trajetsvoiture');

			$this->db->where('id',$delete[0]->id);
			$this->db->delete('detailcircuit');

		}
		$this->db->trans_complete();

		
	}



	public function assignchauffeur($data)
	{
		$sql="SELECT datedebut from trajetsvoiture as vt 
		join detailcircuit as d on vt.idtrajet=d.id where d.datedebut >= ? and vt.numero=?
		and d.arrive=21 and d.arrive != d.depart";
		$query =  $this->db->query($sql, array($data['datedebut'],$data['numero']));
		$result=$query->result();
		$datedebut=$result[0]->datedebut;

		
		if(!empty($datedebut))
		{
			$update="UPDATE trajetsvoiture set idchauffeur=? where
			idtrajet in (select d.id from (select * from trajetsvoiture) as tv join detailcircuit as d on d.id=tv.idtrajet 
			where datedebut between ? and ? and numero=? and (idtrajet=? or depart != 21)) and numero=? ";

			$query2 = $this->db->query($update,array($data['idchauffeur'],$data['datedebut'],$datedebut,$data['numero'],$data['idavant'],$data['numero']));
		}
		else
		{
			$update="UPDATE trajetsvoiture set idchauffeur=? where
			idtrajet in (select d.id from (select * from trajetsvoiture) as tv join detailcircuit as d on d.id=tv.idtrajet 
			where datedebut >= ? and numero=? and (idtrajet=? or depart != 21)) and numero=? ";

			$query2 = $this->db->query($update,array($data['idchauffeur'],$data['datedebut'],$data['numero'],$data['idavant'],$data['numero']));
		}
		
		

	}

	/**
	 *
	 * list des trajets entre deux dates dans un circuit
	 * entre deux dates debut
	 */
	public function trajetsbetween($idcircuit,$datedebut1,$datedebut2)
	{
		$sql="SELECT td.*,circuit.client from trajetdetail as td left join circuit on td.idcircuit=circuit.id where td.idcircuit=? and tdatedebut 
		between ? and ? order by(tdatedebut)";
		$query =  $this->db->query($sql, array($idcircuit,$datedebut1,$datedebut2));
		return $query->result();
	}

	/**
	 * Update trajet trajets 
	 */
	public function TrajetAvecAdj($data)
	{
		/**
		 * cas 1 verif -1 donc update gestion de transport
		 */
		if($data['verif'] == -1)
		{
			$sql="UPDATE detailcircuit set gestiontransport= ? where id= ?";
			$query = $this->db->query($sql, array($data['gestiontransport'],$data['idtrajet']));
		}
		elseif($data['verif'] == 1)
		{
			$this->db->where('id',$data['idapres']);
			$trajetapres=$this->db->get('detailcircuit')->result();
			$this->db->trans_begin();
				if(empty($data['idapres']))
				{
					$this->db->where('id',$data['idtrajet']);
					$trajetactu=$this->db->get('detailcircuit')->result();
					$sqlcircuit="UPDATE circuit set datefin=? where id=?";
					$this->db->query($sqlcircuit, array($data['datefin'],$trajetactu[0]->idcircuit));
				}
				else
				{
					if(strtotime($data['datefin']) > strtotime($trajetapres[0]->datefin))
					{
						return "la date de fin doit être antérieur à la date de fin du prochain trajet ".$trajetapres[0]->datefin;
					}
				}
				$sql="UPDATE detailcircuit set datefin=?,gestiontransport=?,arrive=? where id =?";
				$query = $this->db->query($sql, array($data['datefin'],$data['gestiontransport'],$data['arrive'],$data['idtrajet']));
				$sql1="UPDATE detailcircuit set datedebut=?,depart=? where id =?";
				$query1 = $this->db->query($sql1, array($data['datefin'],$data['arrive'],$data['idapres']));
			$this->db->trans_complete();
			return true;
		}
		elseif($data['verif']==2)
		{
			$this->db->where('id',$data['idavant']);
			$trajeavant=$this->db->get('detailcircuit')->result();
			$this->db->trans_begin();
			if(empty($data['idavant']))
			{
				$this->db->where('id',$data['idtrajet']);
				$trajetactu=$this->db->get('detailcircuit')->result();
				$sqlcircuit="UPDATE circuit set datedebut=? where id=?";
				$this->db->query($sqlcircuit, array($data['datedepart'],$trajetactu[0]->idcircuit));
			}
			else
			{
				if(strtotime($data['datedepart']) < strtotime($trajeavant[0]->datedebut))
				{
					return "la date de debut doit être ultérieur à la date de debut de l'ancien trajet ".$trajeavant[0]->datedebut;
				}

			}
				$sql="UPDATE detailcircuit set datedebut=?,gestiontransport=?,depart=? where id =?";
				$query = $this->db->query($sql, array($data['datedepart'],$data['gestiontransport'],$data['depart'],$data['idtrajet']));
				$sql1="UPDATE detailcircuit set datefin=?,arrive=? where id =?";
				$query1 = $this->db->query($sql1, array($data['datedepart'],$data['depart'],$data['idavant']));
			$this->db->trans_complete();
			return true;
		}
		elseif($data['verif']==0)
		{
			$this->db->where('id',$data['idapres']);
			$trajetapres=$this->db->get('detailcircuit')->result();
			$this->db->trans_begin();
			if(empty($data['idapres']))
			{
				$this->db->where('id',$data['idtrajet']);
				$trajetactu=$this->db->get('detailcircuit')->result();
				$sqlcircuit="UPDATE circuit set datefin=? where id=?";
				$this->db->query($sqlcircuit, array($data['datefin'],$trajetactu[0]->idcircuit));
			}
			else
			{
				if(strtotime($data['datefin']) > strtotime($trajetapres[0]->datefin))
				{
					return "la date de fin doit être antérieur à la date de fin du prochain trajet ".$trajetapres[0]->datefin;
				}
			}
			

			$this->db->where('id',$data['idavant']);
			$trajeavant=$this->db->get('detailcircuit')->result();
			if(empty($data['idavant']))
			{
				$this->db->where('id',$data['idtrajet']);
				$trajetactu=$this->db->get('detailcircuit')->result();
				$sqlcircuit="UPDATE circuit set datedebut=? where id=?";
				$this->db->query($sqlcircuit, array($data['datedepart'],$trajetactu[0]->idcircuit));
			}
			else
			{
				if(strtotime($data['datedepart']) < strtotime($trajeavant[0]->datedebut))
				{
					return "la date de debut doit être ultérieur à la date de debut de l'ancien trajet ".$trajeavant[0]->datedebut;
				}

			}
			
			
			$sql="UPDATE detailcircuit set datefin=?,gestiontransport=?,datedebut=?,depart=?,arrive=? where id =?";
			$query = $this->db->query($sql, array($data['datefin'],$data['gestiontransport'],$data['datedepart'],$data['depart'],$data['arrive'],$data['idtrajet']));
			
			$sql1="UPDATE detailcircuit set datedebut=?,depart=? where id =?";
			$query1 = $this->db->query($sql1, array($data['datefin'],$data['arrive'],$data['idapres']));

			$sql1="UPDATE detailcircuit set datefin=?,arrive=? where id =?";
			$query1 = $this->db->query($sql1, array($data['datedepart'],$data['depart'],$data['idavant']));
			$this->db->trans_complete();
			return true;
		}
	}


	/**
	 * verifier si le trajet peut être modifier 
	 * 1 - trajet avant non modifiable 
	 * 2 - trajet apres non modifiable
	 * 0 - modifiable
	 * -1 - non modifiable
	 */
	public function verifyTrajet($idavant,$idapres)
	{
		$sql="SELECT numero from trajetsvoiture where idtrajet= ? ";
		$query1=$this->db->query($sql, array($idavant));
		$query2=$this->db->query($sql, array($idapres));
		if(empty($query1->result()) && empty($query2->result()))
		{
			return 0;
		}
		elseif(empty($query2->result()) && !empty($query1->result()))
		{
			return 1;
		}
		elseif(empty($query1->result()) && !empty($query2->result()))
		{
			return 2;
		}
		else
		{
			return -1;
		}

	}

	/**
	 * verifie si un trajet dispose d'une voiture
	 */
	public function AvecVoiture($idtrajet)
	{
		$sql="SELECT numero from trajetsvoiture where idtrajet= ? ";
		$query1=$this->db->query($sql, array($idtrajet));
		if(empty($query1->result()))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function circuitAvecVoiture($idcircuit)
	{
		$sql="SELECT numero from voituretrajet where idcircuit= ? ";
		$query1=$this->db->query($sql, array($idcircuit));
		if(empty($query1->result()))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * recherche avancée de circuit 
	*/
	public function find($numero,$chauffeur,$client,$depart,$arrive,$datedebut,$datefin)
	{
		$where="";
		$testdebut=true;
		if(!empty($numero))
		{
			$where .=($testdebut) ? (" where numero in (") : (" and numero in (");

			$debuteach=true;
			foreach ($numero as $num) {
				$where .= ($debuteach) ? ("'".$num."'") : (","."'".$num."'");
				$debuteach=false;
			}

			$where .= ")";
			$testdebut = false;
		}
		if(!empty($chauffeur))
		{
			$where .=($testdebut) ? (" where idchauffeur in (") : (" and idchauffeur in (");

			$debuteach=true;
			foreach ($chauffeur as $num) {
				$where .= ($debuteach) ? ("'".$num."'") : (","."'".$num."'");
				$debuteach=false;
			}

			$where .= ")";
			$testdebut = false;
		}
		if(!empty($client))
		{
			$where .=($testdebut) ? (" where client='".$client."'") : (" and client='".$client."'");
			$testdebut = false;
		}
		if(!empty($depart))
		{
			$where .=($testdebut) ? (" where depart in (") : (" and depart in (");

			$debuteach=true;
			foreach ($depart as $dep) {
				$where .= ($debuteach) ? ($dep) : (",".$dep);
				$debuteach=false;
			}

			$where .= ")";
			$testdebut = false;
			
		}
		if(!empty($arrive))
		{
			$where .=($testdebut) ? (" where arrive in (") : (" and arrive in (");

			$debuteach=true;
			foreach ($arrive as $ar) {
				$where .= ($debuteach) ? ($ar) : (",".$ar);
				$debuteach=false;
			}

			$where .= ")";
			$testdebut = false;
			
		}
		if(!empty($datedebut))
		{
			$where .= ($testdebut) ? (" where td.datedebut>='".$datedebut."'") : (" and td.datedebut>='".$datedebut."'");
			$testdebut = false;
		}
		if(!empty($datefin))
		{
			$where .= ($testdebut) ? (" where td.datefin<='".$datefin."'") : (" and td.datefin<='".$datefin."'");
			$testdebut = false;
		}

		$sql="SELECT td.numero,td.datedebut,td.datefin,td.depart as iddepart,td.arrive as idarrive,ch.nom as chauffeur,c.client,dep.nom as depart,ar.nom as arrive from voituretrajet as td join circuit as c on c.id=td.idcircuit 
		join lieu as dep on dep.id=depart join lieu as ar on ar.id=arrive join chauffeur as ch on ch.id=idchauffeur ".$where;
		$query=$this->db->query($sql);
		return $query->result();
	}
	


    /*
    function for delete Circuit.
    return true.
    created by your name
    created at 13-09-22.
    */
    public function delete($id) {
		if($this->circuitAvecVoiture($id))
		{
			return false;
		}
		$this->db->trans_begin();
			$sqladj="DELETE from listeadjacence where trajet in (select id from detailcircuit where idcircuit = ? ) 
			or trajetadj in (select id from detailcircuit where idcircuit = ?)";
			
			if($this->db->query($sqladj, array($id,$id)) == false)
			{
 				return false;
			}
			

			$sqldetail="DELETE from detailcircuit where idcircuit = ? ";
			if($this->db->query($sqldetail, array($id)) == false)
			{
 				return false;
			}

			$sqlcircuit="DELETE from circuit where id=? ";
			$query = $this->db->query($sqlcircuit, array($id));
			if($this->db->query($sqldetail, array($id)) == false)
			{
 				return false;
			}

		$this->db->trans_complete();
        return true;
    }

    /*
    function for change status of Circuit.
    return activated of deactivated.
    created by your name
    created at 13-09-22.
    */
    public function changeStatus($id) {
        $table=$this->getDataById($id);
		if($table[0]->status==0)
		{
			$this->update($id,array('status' => '1'));
			return "Activated";
		}else{
			$this->update($id,array('status' => '0'));
			return "Deactivated";
		}
    }

}
