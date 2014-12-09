<?php

/**
 * BaseTRelevesCf
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_releve_cf
 * @property integer $id_cf
 * @property integer $id_taxon
 * @property integer $id_critere_cf
 * @property integer $am
 * @property integer $af
 * @property integer $ai
 * @property integer $na
 * @property integer $sai
 * @property integer $jeune
 * @property integer $yearling
 * @property integer $cd_ref_origine
 * @property string $nom_taxon_saisi
 * @property string $commentaire
 * @property boolean $supprime
 * @property boolean $prelevement
 * @property BibCriteresCf $BibCriteresCf
 * @property BibTaxonsFaunePn $BibTaxonsFaunePn
 * @property TFichesCf $TFichesCf
 * @property Doctrine_Collection $VNomadeTaxonsFaune
 * 
 * @method integer             getIdReleveCf()         Returns the current record's "id_releve_cf" value
 * @method integer             getIdCf()               Returns the current record's "id_cf" value
 * @method integer             getIdTaxon()            Returns the current record's "id_taxon" value
 * @method integer             getIdCritereCf()        Returns the current record's "id_critere_cf" value
 * @method integer             getAm()                 Returns the current record's "am" value
 * @method integer             getAf()                 Returns the current record's "af" value
 * @method integer             getAi()                 Returns the current record's "ai" value
 * @method integer             getNa()                 Returns the current record's "na" value
 * @method integer             getSai()                Returns the current record's "sai" value
 * @method integer             getJeune()              Returns the current record's "jeune" value
 * @method integer             getYearling()           Returns the current record's "yearling" value
 * @method integer             getCdRefOrigine()       Returns the current record's "cd_ref_origine" value
 * @method string              getNomTaxonSaisi()      Returns the current record's "nom_taxon_saisi" value
 * @method string              getCommentaire()        Returns the current record's "commentaire" value
 * @method boolean             getSupprime()           Returns the current record's "supprime" value
 * @method boolean             getPrelevement()        Returns the current record's "prelevement" value
 * @method BibCriteresCf       getBibCriteresCf()      Returns the current record's "BibCriteresCf" value
 * @method BibTaxonsFaunePn    getBibTaxonsFaunePn()   Returns the current record's "BibTaxonsFaunePn" value
 * @method TFichesCf           getTFichesCf()          Returns the current record's "TFichesCf" value
 * @method Doctrine_Collection getVNomadeTaxonsFaune() Returns the current record's "VNomadeTaxonsFaune" collection
 * @method TRelevesCf          setIdReleveCf()         Sets the current record's "id_releve_cf" value
 * @method TRelevesCf          setIdCf()               Sets the current record's "id_cf" value
 * @method TRelevesCf          setIdTaxon()            Sets the current record's "id_taxon" value
 * @method TRelevesCf          setIdCritereCf()        Sets the current record's "id_critere_cf" value
 * @method TRelevesCf          setAm()                 Sets the current record's "am" value
 * @method TRelevesCf          setAf()                 Sets the current record's "af" value
 * @method TRelevesCf          setAi()                 Sets the current record's "ai" value
 * @method TRelevesCf          setNa()                 Sets the current record's "na" value
 * @method TRelevesCf          setSai()                Sets the current record's "sai" value
 * @method TRelevesCf          setJeune()              Sets the current record's "jeune" value
 * @method TRelevesCf          setYearling()           Sets the current record's "yearling" value
 * @method TRelevesCf          setCdRefOrigine()       Sets the current record's "cd_ref_origine" value
 * @method TRelevesCf          setNomTaxonSaisi()      Sets the current record's "nom_taxon_saisi" value
 * @method TRelevesCf          setCommentaire()        Sets the current record's "commentaire" value
 * @method TRelevesCf          setSupprime()           Sets the current record's "supprime" value
 * @method TRelevesCf          setPrelevement()        Sets the current record's "prelevement" value
 * @method TRelevesCf          setBibCriteresCf()      Sets the current record's "BibCriteresCf" value
 * @method TRelevesCf          setBibTaxonsFaunePn()   Sets the current record's "BibTaxonsFaunePn" value
 * @method TRelevesCf          setTFichesCf()          Sets the current record's "TFichesCf" value
 * @method TRelevesCf          setVNomadeTaxonsFaune() Sets the current record's "VNomadeTaxonsFaune" collection
 * 
 * @package    faune
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTRelevesCf extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('contactfaune.t_releves_cf');
        $this->hasColumn('id_releve_cf', 'integer', 5, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 5,
             ));
        $this->hasColumn('id_cf', 'integer', 5, array(
             'type' => 'integer',
             'length' => 5,
             ));
        $this->hasColumn('id_taxon', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_critere_cf', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('am', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('af', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('ai', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('na', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('sai', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('jeune', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('yearling', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('cd_ref_origine', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('nom_taxon_saisi', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('commentaire', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('supprime', 'boolean', 1, array(
             'type' => 'boolean',
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('prelevement', 'boolean', 1, array(
             'type' => 'boolean',
             'notnull' => true,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('BibCriteresCf', array(
             'local' => 'id_critere_cf',
             'foreign' => 'id_critere_cf'));

        $this->hasOne('BibTaxonsFaunePn', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasOne('TFichesCf', array(
             'local' => 'id_cf',
             'foreign' => 'id_cf'));

        $this->hasMany('VNomadeTaxonsFaune', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));
    }
}