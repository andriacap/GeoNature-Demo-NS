from flask import current_app

# nomenclatures fields
counting_nomenclatures = [
    "id_nomenclature_life_stage",
    "id_nomenclature_sex",
    "id_nomenclature_obj_count",
    "id_nomenclature_type_count",
    "id_nomenclature_valid_status",
]

occ_nomenclatures = [
    "id_nomenclature_obs_technique",
    "id_nomenclature_bio_condition",
    "id_nomenclature_bio_status",
    "id_nomenclature_naturalness",
    "id_nomenclature_exist_proof",
    "id_nomenclature_observation_status",
    "id_nomenclature_blurring",
    "id_nomenclature_determination_method",
    "id_nomenclature_behaviour",
]

releve_nomenclatures = [
    "id_nomenclature_tech_collect_campanule",
    "id_nomenclature_grp_typ",
]


def get_nomenclature_filters(params):
    """
        return all the nomenclatures from query paramters
        filters by table
    """
    counting_filters = []
    occurrence_filters = []
    releve_filters = []

    for p in params:
        if p[:2] == "id":
            if p in counting_nomenclatures:
                counting_filters.append(p)
            elif p in occ_nomenclatures:
                occurrence_filters.append(p)
            elif p in releve_nomenclatures:
                releve_filters.append(p)
    return releve_filters, occurrence_filters, counting_filters


def is_already_joined(my_class, query):
    """
    Check if the given class is already present is the current query
    _class: SQLAlchemy class
    query: SQLAlchemy query
    return boolean
    """
    return my_class in [mapper.class_ for mapper in query._join_entities]


def get_dataset_config(id_dataset):
    """
    Fonction renvoyant la configuration du module OCCTAX en fonction du jeux de données 
    """
    if id_dataset.isnumeric():
        return next(
            (c["FORMFIELDS"] for c in current_app.config['OCCTAX']["DATASETS_CONFIG"] if c["ID_DATASET"] == int(id_dataset)),
            {}
        )
    return {}

def get_default_export_fields(form_fields):
    """
    Fonction renvoyant la liste des colonnes en fonction de la configuration du jeux de données
    """
    col_names = []
    for c in ("RELEVE", "OCCURRENCE", "COUNTING"):
        if c in form_fields:
            for widget in form_fields[c]:
                if "type_widget" in widget and "attribut_name" in widget and widget["type_widget"] != "html":
                    col_names.append(widget["attribut_name"])

    return col_names