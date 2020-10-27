from flask import Blueprint

from utils_flask_sqla.response import json_resp

from geonature.core.gn_profiles.models import VmCorTaxonPhenology

from geonature.utils.env import DB

routes = Blueprint("gn_profiles", __name__)

@routes.route("/cor_taxon_phenology/<cd_ref>", methods=["GET"])
@json_resp
def get_profile(cd_ref):
    q = DB.session.query(VmCorTaxonPhenology)
    data = q.get(cd_ref)
    return data.as_dict()
