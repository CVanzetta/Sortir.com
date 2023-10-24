<?php

namespace App\DTO;

class SearchData
{
private $campus;
private $dateDebut;
private $dateFin;
private $keyword;
private $organisateur;
private $inscrit;
private $nonInscrit;
private $passees;

public function getCampus()
{
return $this->campus;
}

public function setCampus($campus)
{
$this->campus = $campus;
}

public function getDateDebut()
{
return $this->dateDebut;
}

public function setDateDebut($dateDebut)
{
$this->dateDebut = $dateDebut;
}

public function getDateFin()
{
return $this->dateFin;
}

public function setDateFin($dateFin)
{
$this->dateFin = $dateFin;
}

public function getKeyword()
{
return $this->keyword;
}

public function setKeyword($keyword)
{
$this->keyword = $keyword;
}

public function isOrganisateur()
{
return $this->organisateur;
}

public function setOrganisateur($organisateur)
{
$this->organisateur = $organisateur;
}

public function isInscrit()
{
return $this->inscrit;
}

public function setInscrit($inscrit)
{
$this->inscrit = $inscrit;
}

public function isNonInscrit()
{
return $this->nonInscrit;
}

public function setNonInscrit($nonInscrit)
{
$this->nonInscrit = $nonInscrit;
}

public function isPassees()
{
return $this->passees;
}

public function setPassees($passees)
{
$this->passees = $passees;
}

    public function getNonInscrit()
    {
        return $this->nonInscrit;
    }

    public function getInscrit()
    {
        return $this->inscrit;
    }

    public function getOrganisateur()
    {
        return $this->organisateur;
    }

}
