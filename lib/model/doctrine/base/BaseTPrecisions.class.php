<?php

/**
 * BaseTPrecisions
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_precision
 * @property string $nom_precision
 * @property string $desc_precision
 * @property Doctrine_Collection $Synthesefaune
 * 
 * @method integer             getIdPrecision()    Returns the current record's "id_precision" value
 * @method string              getNomPrecision()   Returns the current record's "nom_precision" value
 * @method string              getDescPrecision()  Returns the current record's "desc_precision" value
 * @method Doctrine_Collection getSynthesefaune()  Returns the current record's "Synthesefaune" collection
 * @method TPrecisions         setIdPrecision()    Sets the current record's "id_precision" value
 * @method TPrecisions         setNomPrecision()   Sets the current record's "nom_precision" value
 * @method TPrecisions         setDescPrecision()  Sets the current record's "desc_precision" value
 * @method TPrecisions         setSynthesefaune()  Sets the current record's "Synthesefaune" collection
 * 
 * @package    faune
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTPrecisions extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('meta.t_precisions');
        $this->hasColumn('id_precision', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('nom_precision', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('desc_precision', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Synthesefaune', array(
             'local' => 'id_precision',
             'foreign' => 'id_precision'));
    }
}