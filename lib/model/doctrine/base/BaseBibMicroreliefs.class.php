<?php

/**
 * BaseBibMicroreliefs
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_microrelief
 * @property string $nom_microrelief
 * @property Doctrine_Collection $CorFsMicrorelief
 * 
 * @method integer             getIdMicrorelief()    Returns the current record's "id_microrelief" value
 * @method string              getNomMicrorelief()   Returns the current record's "nom_microrelief" value
 * @method Doctrine_Collection getCorFsMicrorelief() Returns the current record's "CorFsMicrorelief" collection
 * @method BibMicroreliefs     setIdMicrorelief()    Sets the current record's "id_microrelief" value
 * @method BibMicroreliefs     setNomMicrorelief()   Sets the current record's "nom_microrelief" value
 * @method BibMicroreliefs     setCorFsMicrorelief() Sets the current record's "CorFsMicrorelief" collection
 * 
 * @package    geonature
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBibMicroreliefs extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('florestation.bib_microreliefs');
        $this->hasColumn('id_microrelief', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('nom_microrelief', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('CorFsMicrorelief', array(
             'local' => 'id_microrelief',
             'foreign' => 'id_microrelief'));
    }
}