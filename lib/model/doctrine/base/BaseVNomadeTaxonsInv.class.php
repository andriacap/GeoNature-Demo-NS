<?php

/**
 * BaseVNomadeTaxonsInv
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_taxon
 * @property integer $cd_ref
 * @property integer $cd_nom
 * @property string $nom_latin
 * @property string $nom_francais
 * @property integer $id_classe
 * @property boolean $patrimonial
 * @property string $message
 * @property BibTaxons $BibTaxons
 * @property CorUniteTaxonInv $CorUniteTaxonInv
 * @property TRelevesInv $TRelevesInv
 * 
 * @method integer          getIdTaxon()          Returns the current record's "id_taxon" value
 * @method integer          getCdRef()            Returns the current record's "cd_ref" value
 * @method integer          getCdNom()            Returns the current record's "cd_nom" value
 * @method string           getNomLatin()         Returns the current record's "nom_latin" value
 * @method string           getNomFrancais()      Returns the current record's "nom_francais" value
 * @method integer          getIdClasse()         Returns the current record's "id_classe" value
 * @method boolean          getPatrimonial()      Returns the current record's "patrimonial" value
 * @method string           getMessage()          Returns the current record's "message" value
 * @method BibTaxons        getBibTaxons()        Returns the current record's "BibTaxons" value
 * @method CorUniteTaxonInv getCorUniteTaxonInv() Returns the current record's "CorUniteTaxonInv" value
 * @method TRelevesInv      getTRelevesInv()      Returns the current record's "TRelevesInv" value
 * @method VNomadeTaxonsInv setIdTaxon()          Sets the current record's "id_taxon" value
 * @method VNomadeTaxonsInv setCdRef()            Sets the current record's "cd_ref" value
 * @method VNomadeTaxonsInv setCdNom()            Sets the current record's "cd_nom" value
 * @method VNomadeTaxonsInv setNomLatin()         Sets the current record's "nom_latin" value
 * @method VNomadeTaxonsInv setNomFrancais()      Sets the current record's "nom_francais" value
 * @method VNomadeTaxonsInv setIdClasse()         Sets the current record's "id_classe" value
 * @method VNomadeTaxonsInv setPatrimonial()      Sets the current record's "patrimonial" value
 * @method VNomadeTaxonsInv setMessage()          Sets the current record's "message" value
 * @method VNomadeTaxonsInv setBibTaxons()        Sets the current record's "BibTaxons" value
 * @method VNomadeTaxonsInv setCorUniteTaxonInv() Sets the current record's "CorUniteTaxonInv" value
 * @method VNomadeTaxonsInv setTRelevesInv()      Sets the current record's "TRelevesInv" value
 * 
 * @package    geonature
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseVNomadeTaxonsInv extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('contactinv.v_nomade_taxons_inv');
        $this->hasColumn('id_taxon', 'integer', 8, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 8,
             ));
        $this->hasColumn('cd_ref', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             ));
        $this->hasColumn('cd_nom', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             ));
        $this->hasColumn('nom_latin', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('nom_francais', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('id_classe', 'integer', 8, array(
             'type' => 'integer',
             'length' => 8,
             ));
        $this->hasColumn('patrimonial', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
        $this->hasColumn('message', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('BibTaxons', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasOne('CorUniteTaxonInv', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasOne('TRelevesInv', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));
    }
}