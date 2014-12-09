<?php

/**
 * BaseBibCriteresCf
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_critere_cf
 * @property string $code_critere_cf
 * @property string $nom_critere_cf
 * @property integer $tri_cf
 * @property integer $id_critere_synthese
 * @property Doctrine_Collection $CorCritereClasse
 * @property Doctrine_Collection $TRelevesCf
 * 
 * @method integer             getIdCritereCf()         Returns the current record's "id_critere_cf" value
 * @method string              getCodeCritereCf()       Returns the current record's "code_critere_cf" value
 * @method string              getNomCritereCf()        Returns the current record's "nom_critere_cf" value
 * @method integer             getTriCf()               Returns the current record's "tri_cf" value
 * @method integer             getIdCritereSynthese()   Returns the current record's "id_critere_synthese" value
 * @method Doctrine_Collection getCorCritereClasse()    Returns the current record's "CorCritereClasse" collection
 * @method Doctrine_Collection getTRelevesCf()          Returns the current record's "TRelevesCf" collection
 * @method BibCriteresCf       setIdCritereCf()         Sets the current record's "id_critere_cf" value
 * @method BibCriteresCf       setCodeCritereCf()       Sets the current record's "code_critere_cf" value
 * @method BibCriteresCf       setNomCritereCf()        Sets the current record's "nom_critere_cf" value
 * @method BibCriteresCf       setTriCf()               Sets the current record's "tri_cf" value
 * @method BibCriteresCf       setIdCritereSynthese()   Sets the current record's "id_critere_synthese" value
 * @method BibCriteresCf       setCorCritereClasse()    Sets the current record's "CorCritereClasse" collection
 * @method BibCriteresCf       setTRelevesCf()          Sets the current record's "TRelevesCf" collection
 * 
 * @package    faune
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBibCriteresCf extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('contactfaune.bib_criteres_cf');
        $this->hasColumn('id_critere_cf', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('code_critere_cf', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             ));
        $this->hasColumn('nom_critere_cf', 'string', 90, array(
             'type' => 'string',
             'length' => 90,
             ));
        $this->hasColumn('tri_cf', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('id_critere_synthese', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('CorCritereClasse', array(
             'local' => 'id_critere_cf',
             'foreign' => 'id_critere_cf'));

        $this->hasMany('TRelevesCf', array(
             'local' => 'id_critere_cf',
             'foreign' => 'id_critere_cf'));
    }
}