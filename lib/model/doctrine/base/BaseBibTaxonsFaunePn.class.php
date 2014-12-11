<?php

/**
 * BaseBibTaxonsFaunePn
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_taxon
 * @property integer $cd_nom
 * @property integer $id_groupe
 * @property string $id_frequence
 * @property integer $id_importance_population
 * @property integer $id_responsabilite_pn
 * @property integer $id_statut_migration
 * @property string $nom_latin
 * @property string $nom_francais
 * @property string $auteur
 * @property string $syn_fr
 * @property string $syn_la
 * @property integer $prot_fv
 * @property boolean $sap
 * @property boolean $patrimonial
 * @property boolean $protection_stricte
 * @property boolean $reproducteur
 * @property BibGroupes $BibGroupes
 * @property Taxref $Taxref
 * @property BibImportancesPopulation $BibImportancesPopulation
 * @property BibResponsabilitesPn $BibResponsabilitesPn
 * @property BibStatutsMigration $BibStatutsMigration
 * @property Doctrine_Collection $CorMessageTaxonCf
 * @property Doctrine_Collection $CorMessageTaxonInv
 * @property Doctrine_Collection $CorUniteTaxon
 * @property Doctrine_Collection $CorUniteTaxonInv
 * @property Doctrine_Collection $Synthesefaune
 * @property Doctrine_Collection $TRelevesCf
 * @property Doctrine_Collection $TRelevesInv
 * @property Doctrine_Collection $VNomadeTaxonsFaune
 * @property Doctrine_Collection $VNomadeTaxonsInv
 * @property Doctrine_Collection $VTreeTaxonsSynthese
 * 
 * @method integer                  getIdTaxon()                  Returns the current record's "id_taxon" value
 * @method integer                  getCdNom()                    Returns the current record's "cd_nom" value
 * @method integer                  getIdGroupe()                 Returns the current record's "id_groupe" value
 * @method string                   getIdFrequence()              Returns the current record's "id_frequence" value
 * @method integer                  getIdImportancePopulation()   Returns the current record's "id_importance_population" value
 * @method integer                  getIdResponsabilitePn()       Returns the current record's "id_responsabilite_pn" value
 * @method integer                  getIdStatutMigration()        Returns the current record's "id_statut_migration" value
 * @method string                   getNomLatin()                 Returns the current record's "nom_latin" value
 * @method string                   getNomFrancais()              Returns the current record's "nom_francais" value
 * @method string                   getAuteur()                   Returns the current record's "auteur" value
 * @method string                   getSynFr()                    Returns the current record's "syn_fr" value
 * @method string                   getSynLa()                    Returns the current record's "syn_la" value
 * @method integer                  getProtFv()                   Returns the current record's "prot_fv" value
 * @method boolean                  getSap()                      Returns the current record's "sap" value
 * @method boolean                  getPatrimonial()              Returns the current record's "patrimonial" value
 * @method boolean                  getProtectionStricte()        Returns the current record's "protection_stricte" value
 * @method boolean                  getReproducteur()             Returns the current record's "reproducteur" value
 * @method BibGroupes               getBibGroupes()               Returns the current record's "BibGroupes" value
 * @method Taxref                   getTaxref()                   Returns the current record's "Taxref" value
 * @method BibImportancesPopulation getBibImportancesPopulation() Returns the current record's "BibImportancesPopulation" value
 * @method BibResponsabilitesPn     getBibResponsabilitesPn()     Returns the current record's "BibResponsabilitesPn" value
 * @method BibStatutsMigration      getBibStatutsMigration()      Returns the current record's "BibStatutsMigration" value
 * @method Doctrine_Collection      getCorMessageTaxonCf()        Returns the current record's "CorMessageTaxonCf" collection
 * @method Doctrine_Collection      getCorMessageTaxonInv()       Returns the current record's "CorMessageTaxonInv" collection
 * @method Doctrine_Collection      getCorUniteTaxon()            Returns the current record's "CorUniteTaxon" collection
 * @method Doctrine_Collection      getCorUniteTaxonInv()         Returns the current record's "CorUniteTaxonInv" collection
 * @method Doctrine_Collection      getSynthesefaune()            Returns the current record's "Synthesefaune" collection
 * @method Doctrine_Collection      getTRelevesCf()               Returns the current record's "TRelevesCf" collection
 * @method Doctrine_Collection      getTRelevesInv()              Returns the current record's "TRelevesInv" collection
 * @method Doctrine_Collection      getVNomadeTaxonsFaune()       Returns the current record's "VNomadeTaxonsFaune" collection
 * @method Doctrine_Collection      getVNomadeTaxonsInv()         Returns the current record's "VNomadeTaxonsInv" collection
 * @method Doctrine_Collection      getVTreeTaxonsSynthese()      Returns the current record's "VTreeTaxonsSynthese" collection
 * @method BibTaxonsFaunePn         setIdTaxon()                  Sets the current record's "id_taxon" value
 * @method BibTaxonsFaunePn         setCdNom()                    Sets the current record's "cd_nom" value
 * @method BibTaxonsFaunePn         setIdGroupe()                 Sets the current record's "id_groupe" value
 * @method BibTaxonsFaunePn         setIdFrequence()              Sets the current record's "id_frequence" value
 * @method BibTaxonsFaunePn         setIdImportancePopulation()   Sets the current record's "id_importance_population" value
 * @method BibTaxonsFaunePn         setIdResponsabilitePn()       Sets the current record's "id_responsabilite_pn" value
 * @method BibTaxonsFaunePn         setIdStatutMigration()        Sets the current record's "id_statut_migration" value
 * @method BibTaxonsFaunePn         setNomLatin()                 Sets the current record's "nom_latin" value
 * @method BibTaxonsFaunePn         setNomFrancais()              Sets the current record's "nom_francais" value
 * @method BibTaxonsFaunePn         setAuteur()                   Sets the current record's "auteur" value
 * @method BibTaxonsFaunePn         setSynFr()                    Sets the current record's "syn_fr" value
 * @method BibTaxonsFaunePn         setSynLa()                    Sets the current record's "syn_la" value
 * @method BibTaxonsFaunePn         setProtFv()                   Sets the current record's "prot_fv" value
 * @method BibTaxonsFaunePn         setSap()                      Sets the current record's "sap" value
 * @method BibTaxonsFaunePn         setPatrimonial()              Sets the current record's "patrimonial" value
 * @method BibTaxonsFaunePn         setProtectionStricte()        Sets the current record's "protection_stricte" value
 * @method BibTaxonsFaunePn         setReproducteur()             Sets the current record's "reproducteur" value
 * @method BibTaxonsFaunePn         setBibGroupes()               Sets the current record's "BibGroupes" value
 * @method BibTaxonsFaunePn         setTaxref()                   Sets the current record's "Taxref" value
 * @method BibTaxonsFaunePn         setBibImportancesPopulation() Sets the current record's "BibImportancesPopulation" value
 * @method BibTaxonsFaunePn         setBibResponsabilitesPn()     Sets the current record's "BibResponsabilitesPn" value
 * @method BibTaxonsFaunePn         setBibStatutsMigration()      Sets the current record's "BibStatutsMigration" value
 * @method BibTaxonsFaunePn         setCorMessageTaxonCf()        Sets the current record's "CorMessageTaxonCf" collection
 * @method BibTaxonsFaunePn         setCorMessageTaxonInv()       Sets the current record's "CorMessageTaxonInv" collection
 * @method BibTaxonsFaunePn         setCorUniteTaxon()            Sets the current record's "CorUniteTaxon" collection
 * @method BibTaxonsFaunePn         setCorUniteTaxonInv()         Sets the current record's "CorUniteTaxonInv" collection
 * @method BibTaxonsFaunePn         setSynthesefaune()            Sets the current record's "Synthesefaune" collection
 * @method BibTaxonsFaunePn         setTRelevesCf()               Sets the current record's "TRelevesCf" collection
 * @method BibTaxonsFaunePn         setTRelevesInv()              Sets the current record's "TRelevesInv" collection
 * @method BibTaxonsFaunePn         setVNomadeTaxonsFaune()       Sets the current record's "VNomadeTaxonsFaune" collection
 * @method BibTaxonsFaunePn         setVNomadeTaxonsInv()         Sets the current record's "VNomadeTaxonsInv" collection
 * @method BibTaxonsFaunePn         setVTreeTaxonsSynthese()      Sets the current record's "VTreeTaxonsSynthese" collection
 * 
 * @package    faune
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBibTaxonsFaunePn extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('taxonomie.bib_taxons_faune_pn');
        $this->hasColumn('id_taxon', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('cd_nom', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_groupe', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_frequence', 'string', 1, array(
             'type' => 'string',
             'length' => 1,
             ));
        $this->hasColumn('id_importance_population', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_responsabilite_pn', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_statut_migration', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('nom_latin', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('nom_francais', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('auteur', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('syn_fr', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('syn_la', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('prot_fv', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('sap', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
        $this->hasColumn('patrimonial', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
        $this->hasColumn('protection_stricte', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
        $this->hasColumn('reproducteur', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('BibGroupes', array(
             'local' => 'id_groupe',
             'foreign' => 'id_groupe'));

        $this->hasOne('Taxref', array(
             'local' => 'cd_nom',
             'foreign' => 'cd_nom'));

        $this->hasOne('BibImportancesPopulation', array(
             'local' => 'id_importance_population',
             'foreign' => 'id_importance_population'));

        $this->hasOne('BibResponsabilitesPn', array(
             'local' => 'id_responsabilite_pn',
             'foreign' => 'id_responsabilite_pn'));

        $this->hasOne('BibStatutsMigration', array(
             'local' => 'id_statut_migration',
             'foreign' => 'id_statut_migration'));

        $this->hasMany('CorMessageTaxonCf', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('CorMessageTaxonInv', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('CorUniteTaxon', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('CorUniteTaxonInv', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('Synthesefaune', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('TRelevesCf', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('TRelevesInv', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('VNomadeTaxonsFaune', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('VNomadeTaxonsInv', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));

        $this->hasMany('VTreeTaxonsSynthese', array(
             'local' => 'id_taxon',
             'foreign' => 'id_taxon'));
    }
}