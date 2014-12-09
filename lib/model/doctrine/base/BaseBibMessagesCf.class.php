<?php

/**
 * BaseBibMessagesCf
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_message_cf
 * @property string $texte_message_cf
 * @property Doctrine_Collection $CorMessageTaxonCf
 * 
 * @method integer             getIdMessageCf()       Returns the current record's "id_message_cf" value
 * @method string              getTexteMessageCf()    Returns the current record's "texte_message_cf" value
 * @method Doctrine_Collection getCorMessageTaxonCf() Returns the current record's "CorMessageTaxonCf" collection
 * @method BibMessagesCf       setIdMessageCf()       Sets the current record's "id_message_cf" value
 * @method BibMessagesCf       setTexteMessageCf()    Sets the current record's "texte_message_cf" value
 * @method BibMessagesCf       setCorMessageTaxonCf() Sets the current record's "CorMessageTaxonCf" collection
 * 
 * @package    faune
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBibMessagesCf extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('contactfaune.bib_messages_cf');
        $this->hasColumn('id_message_cf', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('texte_message_cf', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('CorMessageTaxonCf', array(
             'local' => 'id_message_cf',
             'foreign' => 'id_message_cf'));
    }
}