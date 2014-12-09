<?php

/**
 * BaseBibProgrammes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_programme
 * @property string $nom_programme
 * @property string $desc_programme
 * @property Doctrine_Collection $BibLots
 * 
 * @method integer             getIdProgramme()    Returns the current record's "id_programme" value
 * @method string              getNomProgramme()   Returns the current record's "nom_programme" value
 * @method string              getDescProgramme()  Returns the current record's "desc_programme" value
 * @method Doctrine_Collection getBibLots()        Returns the current record's "BibLots" collection
 * @method BibProgrammes       setIdProgramme()    Sets the current record's "id_programme" value
 * @method BibProgrammes       setNomProgramme()   Sets the current record's "nom_programme" value
 * @method BibProgrammes       setDescProgramme()  Sets the current record's "desc_programme" value
 * @method BibProgrammes       setBibLots()        Sets the current record's "BibLots" collection
 * 
 * @package    faune
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBibProgrammes extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('meta.bib_programmes');
        $this->hasColumn('id_programme', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('nom_programme', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('desc_programme', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('BibLots', array(
             'local' => 'id_programme',
             'foreign' => 'id_programme'));
    }
}