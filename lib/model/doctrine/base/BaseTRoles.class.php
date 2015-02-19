<?php

/**
 * BaseTRoles
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property boolean $groupe
 * @property integer $id_role
 * @property string $organisme
 * @property integer $id_organisme
 * @property string $identifiant
 * @property string $nom_role
 * @property string $prenom_role
 * @property string $desc_role
 * @property string $pass
 * @property string $email
 * @property integer $id_unite
 * @property boolean $pn
 * @property boolean $assermentes
 * @property boolean $enposte
 * @property timestamp $dernieracces
 * @property string $session_appli
 * @property timestamp $date_insert
 * @property timestamp $date_update
 * @property BibUnites $BibUnites
 * @property BibOrganismes $BibOrganismes
 * @property Doctrine_Collection $CorBryoObservateur
 * @property Doctrine_Collection $CorFsObservateur
 * @property Doctrine_Collection $CorRoleDroitApplication
 * @property Doctrine_Collection $CorRoleFicheCf
 * @property Doctrine_Collection $CorRoleFicheInv
 * @property Doctrine_Collection $CorRoleMenu
 * @property Doctrine_Collection $CorRoles
 * @property Doctrine_Collection $CorZpObs
 * 
 * @method boolean             getGroupe()                  Returns the current record's "groupe" value
 * @method integer             getIdRole()                  Returns the current record's "id_role" value
 * @method string              getOrganisme()               Returns the current record's "organisme" value
 * @method integer             getIdOrganisme()             Returns the current record's "id_organisme" value
 * @method string              getIdentifiant()             Returns the current record's "identifiant" value
 * @method string              getNomRole()                 Returns the current record's "nom_role" value
 * @method string              getPrenomRole()              Returns the current record's "prenom_role" value
 * @method string              getDescRole()                Returns the current record's "desc_role" value
 * @method string              getPass()                    Returns the current record's "pass" value
 * @method string              getEmail()                   Returns the current record's "email" value
 * @method integer             getIdUnite()                 Returns the current record's "id_unite" value
 * @method boolean             getPn()                      Returns the current record's "pn" value
 * @method boolean             getAssermentes()             Returns the current record's "assermentes" value
 * @method boolean             getEnposte()                 Returns the current record's "enposte" value
 * @method timestamp           getDernieracces()            Returns the current record's "dernieracces" value
 * @method string              getSessionAppli()            Returns the current record's "session_appli" value
 * @method timestamp           getDateInsert()              Returns the current record's "date_insert" value
 * @method timestamp           getDateUpdate()              Returns the current record's "date_update" value
 * @method BibUnites           getBibUnites()               Returns the current record's "BibUnites" value
 * @method BibOrganismes       getBibOrganismes()           Returns the current record's "BibOrganismes" value
 * @method Doctrine_Collection getCorBryoObservateur()      Returns the current record's "CorBryoObservateur" collection
 * @method Doctrine_Collection getCorFsObservateur()        Returns the current record's "CorFsObservateur" collection
 * @method Doctrine_Collection getCorRoleDroitApplication() Returns the current record's "CorRoleDroitApplication" collection
 * @method Doctrine_Collection getCorRoleFicheCf()          Returns the current record's "CorRoleFicheCf" collection
 * @method Doctrine_Collection getCorRoleFicheInv()         Returns the current record's "CorRoleFicheInv" collection
 * @method Doctrine_Collection getCorRoleMenu()             Returns the current record's "CorRoleMenu" collection
 * @method Doctrine_Collection getCorRoles()                Returns the current record's "CorRoles" collection
 * @method Doctrine_Collection getCorZpObs()                Returns the current record's "CorZpObs" collection
 * @method TRoles              setGroupe()                  Sets the current record's "groupe" value
 * @method TRoles              setIdRole()                  Sets the current record's "id_role" value
 * @method TRoles              setOrganisme()               Sets the current record's "organisme" value
 * @method TRoles              setIdOrganisme()             Sets the current record's "id_organisme" value
 * @method TRoles              setIdentifiant()             Sets the current record's "identifiant" value
 * @method TRoles              setNomRole()                 Sets the current record's "nom_role" value
 * @method TRoles              setPrenomRole()              Sets the current record's "prenom_role" value
 * @method TRoles              setDescRole()                Sets the current record's "desc_role" value
 * @method TRoles              setPass()                    Sets the current record's "pass" value
 * @method TRoles              setEmail()                   Sets the current record's "email" value
 * @method TRoles              setIdUnite()                 Sets the current record's "id_unite" value
 * @method TRoles              setPn()                      Sets the current record's "pn" value
 * @method TRoles              setAssermentes()             Sets the current record's "assermentes" value
 * @method TRoles              setEnposte()                 Sets the current record's "enposte" value
 * @method TRoles              setDernieracces()            Sets the current record's "dernieracces" value
 * @method TRoles              setSessionAppli()            Sets the current record's "session_appli" value
 * @method TRoles              setDateInsert()              Sets the current record's "date_insert" value
 * @method TRoles              setDateUpdate()              Sets the current record's "date_update" value
 * @method TRoles              setBibUnites()               Sets the current record's "BibUnites" value
 * @method TRoles              setBibOrganismes()           Sets the current record's "BibOrganismes" value
 * @method TRoles              setCorBryoObservateur()      Sets the current record's "CorBryoObservateur" collection
 * @method TRoles              setCorFsObservateur()        Sets the current record's "CorFsObservateur" collection
 * @method TRoles              setCorRoleDroitApplication() Sets the current record's "CorRoleDroitApplication" collection
 * @method TRoles              setCorRoleFicheCf()          Sets the current record's "CorRoleFicheCf" collection
 * @method TRoles              setCorRoleFicheInv()         Sets the current record's "CorRoleFicheInv" collection
 * @method TRoles              setCorRoleMenu()             Sets the current record's "CorRoleMenu" collection
 * @method TRoles              setCorRoles()                Sets the current record's "CorRoles" collection
 * @method TRoles              setCorZpObs()                Sets the current record's "CorZpObs" collection
 * 
 * @package    geonature
 * @subpackage model
 * @author     Gil Deluermoz
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTRoles extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('utilisateurs.t_roles');
        $this->hasColumn('groupe', 'boolean', 1, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 'false',
             'length' => 1,
             ));
        $this->hasColumn('id_role', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'sequence' => 't_roles_id',
             'length' => 4,
             ));
        $this->hasColumn('organisme', 'string', null, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '',
             ));
        $this->hasColumn('id_organisme', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('identifiant', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('nom_role', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('prenom_role', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('desc_role', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('pass', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('email', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             ));
        $this->hasColumn('id_unite', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('pn', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
        $this->hasColumn('assermentes', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
        $this->hasColumn('enposte', 'boolean', 1, array(
             'type' => 'boolean',
             'length' => 1,
             ));
        $this->hasColumn('dernieracces', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
        $this->hasColumn('session_appli', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('date_insert', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
        $this->hasColumn('date_update', 'timestamp', 25, array(
             'type' => 'timestamp',
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('BibUnites', array(
             'local' => 'id_unite',
             'foreign' => 'id_unite'));

        $this->hasOne('BibOrganismes', array(
             'local' => 'id_organisme',
             'foreign' => 'id_organisme'));

        $this->hasMany('CorBryoObservateur', array(
             'local' => 'id_role',
             'foreign' => 'id_role'));

        $this->hasMany('CorFsObservateur', array(
             'local' => 'id_role',
             'foreign' => 'id_role'));

        $this->hasMany('CorRoleDroitApplication', array(
             'local' => 'id_role',
             'foreign' => 'id_role'));

        $this->hasMany('CorRoleFicheCf', array(
             'local' => 'id_role',
             'foreign' => 'id_role'));

        $this->hasMany('CorRoleFicheInv', array(
             'local' => 'id_role',
             'foreign' => 'id_role'));

        $this->hasMany('CorRoleMenu', array(
             'local' => 'id_role',
             'foreign' => 'id_role'));

        $this->hasMany('CorRoles', array(
             'local' => 'id_role',
             'foreign' => 'id_role_groupe'));

        $this->hasMany('CorZpObs', array(
             'local' => 'id_role',
             'foreign' => 'codeobs'));
    }
}