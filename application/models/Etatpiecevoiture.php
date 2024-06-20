<?php

class Etatpiecevoiture extends CI_Model {

    /*
    return all Etatpiecevoitures.
    created by your name
    created at 31-08-22.
    */
    public function getAll() {
        return $this->db->get('etatpiecevoiture')->result();
    }

    public function etatpiece($numero)
    {
        $sql="SELECT v.numero AS numero,v.status AS status,pr.nom AS nom,
        p.nom AS piece,en.kilometrage AS kilometrage,en.idpiece AS idpiece,
        max(vp.kilometrage) AS kmentretien,vp.entretiendate AS entretiendate,
        kilometragevoiture.kmapres AS kmapres,
        max(vp.kilometrage) + en.kilometrage - kilometragevoiture.kmapres AS kmrestant 
        from (((((vehicule v 
        join profilentretien pr on(v.identretien = pr.id)) 
        join entretienpiece en on(pr.id = en.identretien)) 
        join piece p on(en.idpiece = p.id)) 
        join vehiculepiece vp 
            on(en.idpiece = vp.idpiece 
            and v.numero = vp.numero 
            and v.identretien = vp.identretien)) 
        join kilometragevoiture) 
        where kilometragevoiture.kmapres = (
        select max(kmv2.kmapres) from kilometragevoiture kmv2 
            where kmv2.numero = v.numero) and v.numero=? group by v.numero,en.idpiece";

        $query=$this->db->query($sql,array($numero));
        return $query->result();
    }
    

}