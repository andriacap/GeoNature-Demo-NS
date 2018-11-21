SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--DROP SCHEMA gn_permissions CASCADE;
CREATE SCHEMA gn_permissions;

SET search_path = gn_permissions, pg_catalog;
SET default_with_oids = false;

-------------
--FUNCTIONS--
-------------

CREATE OR REPLACE FUNCTION is_user_has_scope_permission(
 myuser integer,
 mycodemodule character varying,
 myactioncode character varying,
 myscope integer
)
 RETURNS boolean AS
$BODY$
-- the function say if the given user can do the requested action in the requested module with its scope level
-- warning: NO heritage between parent and child module
-- USAGE : SELECT gn_persmissions.is_user_has_scope_permission(requested_userid,requested_actionid,requested_module_code,requested_scope);
-- SAMPLE : SELECT gn_permissions.is_user_has_scope_permission(2,'OCCTAX','R',3);
 BEGIN
 IF myactioncode IN (
  SELECT code_action
  FROM gn_permissions.v_users_permissions
  WHERE id_role = myuser AND module_code = mycodemodule AND code_action = myactioncode  AND code_filter::int >= myscope AND code_filter_type = 'SCOPE') THEN
 RETURN true;
 END IF;
 RETURN false;
 END;
$BODY$
 LANGUAGE plpgsql IMMUTABLE
 COST 100;


CREATE OR REPLACE FUNCTION user_max_accessible_data_level_in_module(
 myuser integer,
 myactioncode character varying,
 mymodulecode character varying)
 RETURNS integer AS
$BODY$
DECLARE
 themaxscopelevel integer;
-- the function return the max accessible extend of data the given user can access in the requested module
-- warning: NO heritage between parent and child module
-- USAGE : SELECT gn_permissions.user_max_accessible_data_level_in_module(requested_userid,requested_actionid,requested_moduleid);
-- SAMPLE :SELECT gn_permissions.user_max_accessible_data_level_in_module(2,'U','GEONATURE');
 BEGIN
 SELECT max(code_filter::int) INTO themaxscopelevel
  FROM gn_permissions.v_users_permissions
  WHERE id_role = myuser AND module_code = mymodulecode AND code_action = myactioncode;
 RETURN themaxscopelevel;
 END;
$BODY$
 LANGUAGE plpgsql IMMUTABLE
 COST 100;

 CREATE OR REPLACE FUNCTION cruved_for_user_in_module(
 myuser integer,
 mymodulecode character varying
)
 RETURNS json AS
$BODY$
-- the function return user's CRUVED in the requested module
-- warning: the function not return the parent CRUVED but only the module cruved - no heritage
-- USAGE : SELECT utilisateurs.cruved_for_user_in_module(requested_userid,requested_moduleid);
-- SAMPLE : SELECT utilisateurs.cruved_for_user_in_module(2,3);
DECLARE
 thecruved json;
 BEGIN
  SELECT array_to_json(array_agg(row)) INTO thecruved
  FROM (
  SELECT code_action AS action, max(code_filter::int) AS level
  FROM gn_permissions.v_users_permissions
  WHERE id_role = myuser AND module_code = mymodulecode AND code_filter_type = 'SCOPE'
  GROUP BY code_action) row;
 RETURN thecruved;
 END;
$BODY$
 LANGUAGE plpgsql IMMUTABLE
 COST 100;

---------
--TABLE--
---------

CREATE TABLE t_actions(
    id_action serial NOT NULL,
    code_action character varying(50) NOT NULL,
    description_action text
);

CREATE TABLE bib_filters_type(
    id_filter_type serial NOT NULL,
    code_filter_type character varying(50) NOT NULL,
    description_filter_type text
);

CREATE TABLE t_filters(
    id_filter serial NOT NULL,
    code_filter character varying(50) NOT NULL,
    description_filter text,
    id_filter_type integer NOT NULL
);

CREATE TABLE t_objects(
    id_object serial NOT NULL,
    code_object character varying(50) NOT NULL,
    description_object text
);

-- un objet peut être utilisé dans plusieurs modules
-- ex: TDataset en lecture dans occtax, admin ...
CREATE TABLE cor_object_module(
    id_cor_object_module serial NOT NULL,
    id_object integer NOT NULL,
    id_module integer NOT NULL
);

CREATE TABLE cor_role_action_filter_module_object(
    id_role integer NOT NULL,
    id_action integer NOT NULL,
    id_filter integer NOT NULL,
    id_module integer NOT NULL,
    id_object integer NOT NULL
);


---------------
--PRIMARY KEY--
---------------

ALTER TABLE ONLY t_actions
    ADD CONSTRAINT pk_t_actions PRIMARY KEY (id_action);

ALTER TABLE ONLY t_filters
    ADD CONSTRAINT pk_t_filters PRIMARY KEY (id_filter);

ALTER TABLE ONLY bib_filters_type
    ADD CONSTRAINT pk_bib_filters_type PRIMARY KEY (id_filter_type);

ALTER TABLE ONLY t_objects
    ADD CONSTRAINT pk_t_objects PRIMARY KEY (id_object);

ALTER TABLE ONLY cor_object_module
    ADD CONSTRAINT pk_cor_object_module PRIMARY KEY (id_cor_object_module);

ALTER TABLE ONLY cor_role_action_filter_module_object
    ADD CONSTRAINT pk_cor_r_a_f_m_o PRIMARY KEY (id_role, id_action, id_filter, id_module, id_object);


---------------
--FOREIGN KEY--
---------------

ALTER TABLE ONLY t_filters
  ADD CONSTRAINT  fk_t_filters_id_filter_type FOREIGN KEY (id_filter_type) REFERENCES bib_filters_type(id_filter_type) ON UPDATE CASCADE;

ALTER TABLE ONLY cor_object_module
  ADD CONSTRAINT  fk_cor_object_module_id_module FOREIGN KEY (id_module) REFERENCES gn_commons.t_modules(id_module) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY cor_object_module
  ADD CONSTRAINT  fk_cor_object_module_id_object FOREIGN KEY (id_object) REFERENCES t_objects(id_object) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY cor_role_action_filter_module_object
  ADD CONSTRAINT  fk_cor_r_a_f_m_o_id_role FOREIGN KEY (id_role) REFERENCES utilisateurs.t_roles(id_role) ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE ONLY cor_role_action_filter_module_object
  ADD CONSTRAINT  fk_cor_r_a_f_m_o_id_action FOREIGN KEY (id_action) REFERENCES t_actions(id_action) ON UPDATE CASCADE;

ALTER TABLE ONLY cor_role_action_filter_module_object
  ADD CONSTRAINT  fk_cor_r_a_f_m_o_id_filter FOREIGN KEY (id_filter) REFERENCES t_filters(id_filter) ON UPDATE CASCADE;

ALTER TABLE ONLY cor_role_action_filter_module_object
  ADD CONSTRAINT  fk_cor_r_a_f_m_o_id_object FOREIGN KEY (id_object) REFERENCES t_objects(id_object) ON UPDATE CASCADE;




-----------
-- VIEWS --
-----------

CREATE OR REPLACE VIEW gn_permissions.v_users_permissions AS 
 WITH
 p_user_tag AS (
  SELECT 
  u.id_role,
  u.nom_role,
  u.prenom_role,
  u.groupe,
  u.id_organisme,
  c_1.id_action,
  c_1.id_filter,
  c_1.id_module
  FROM utilisateurs.t_roles u
  JOIN gn_permissions.cor_role_action_filter_module_object c_1 ON c_1.id_role = u.id_role
  WHERE u.groupe = false
 ),
 p_groupe_permission AS (
  SELECT 
  u.id_role,
  u.nom_role,
  u.prenom_role,
  u.groupe,
  u.id_organisme,
  c_1.id_action,
  c_1.id_filter,
  c_1.id_module
  FROM utilisateurs.t_roles u
  JOIN utilisateurs.cor_roles g ON g.id_role_utilisateur = u.id_role OR g.id_role_groupe=u.id_role
  JOIN gn_permissions.cor_role_action_filter_module_object c_1 ON c_1.id_role = g.id_role_groupe
  WHERE (g.id_role_groupe IN (
      SELECT DISTINCT cor_roles.id_role_groupe
      FROM utilisateurs.cor_roles
      )
  )
 ),
 all_user_permission AS (
  SELECT *
  FROM p_user_tag
  UNION
  SELECT *
  FROM p_groupe_permission
)
-- end with
-- main query
 SELECT 
  v.id_role,
  v.nom_role,
  v.prenom_role,
  v.id_organisme,
  v.id_module,
  modules.module_code,
  v.id_action,
  v.id_filter,
  actions.code_action,
  filters.code_filter,
  filter_type.code_filter_type,
  filter_type.id_filter_type
 FROM all_user_permission v
 JOIN gn_permissions.t_actions actions ON actions.id_action = v.id_action
 JOIN gn_permissions.t_filters filters ON filters.id_filter = v.id_filter
 JOIN gn_permissions.bib_filters_type filter_type ON filters.id_filter_type = filter_type.id_filter_type
 JOIN gn_commons.t_modules modules ON modules.id_module = v.id_module
 WHERE v.groupe = false;