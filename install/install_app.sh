#!/bin/bash

# make nvm available 
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion

OS_BITS="$(getconf LONG_BIT)"

# test the server architecture
if [ !"$OS_BITS" == "64" ]; then
   echo "GeoNature must be installed on a 64-bits operating system ; your is $OS_BITS-bits" 1>&2
   exit 1
fi


# settings.ini file path. Default value overwriten by settings-path parameter
cd ../
SETTINGS='config/settings.ini'
POSITIONAL=()
while [[ $# -gt 0 ]]
do
key="$1"
case $key in
    -s|--settings-path)
    SETTINGS="$2"
    shift # Past argument
    shift # Past value
    ;;
    -d|--dev)
    MODE='dev'
    shift # Past argument
    shift # Past value
    ;;
    -h|--help)
    echo ""
    echo "Help for install_app.sh command script."
    echo ""
    echo ""
    echo "Option order matters. Give it in this exact order. All options are optional."
    echo ""
    echo "-s OR --settings-path to give the path of the settings file. "
    echo ""
    echo "-d OR --dev to additionnally install python dev requirements."
    echo ""
    exit
    shift # Past argument
    shift # Past value
    ;;
    *)    # Unknown option
    POSITIONAL+=("$1") # Save it in an array for later
    shift # past argument
    ;;
esac
done
set -- "${POSITIONAL[@]}" # Restore positional parameters

# Import settings file
. ${SETTINGS}

BASE_DIR=$(readlink -e "${0%/*}")


if [ ! -d 'var' ]
then
  mkdir var
fi

if [ ! -d 'var/log' ]
then
  mkdir var/log
  chmod -R 775 var/log/
fi


if [ ! -f config/geonature_config.toml ]; then
  echo "Création du fichier de configuration ..."
  cp config/geonature_config.toml.sample config/geonature_config.toml
  echo "Préparation du fichier de configuration..."
  echo $my_url
  my_url="${my_url//\//\\/}"
  echo $my_url
  sed -i "s/SQLALCHEMY_DATABASE_URI = .*$/SQLALCHEMY_DATABASE_URI = \"postgresql:\/\/$user_pg:$user_pg_pass@$db_host:$db_port\/$db_name\"/" config/geonature_config.toml
  sed -i "s/URL_APPLICATION = .*$/URL_APPLICATION = '${my_url}geonature' /g" config/geonature_config.toml
  sed -i "s/API_ENDPOINT = .*$/API_ENDPOINT = '${my_url}geonature\/api'/g" config/geonature_config.toml
  sed -i "s/API_TAXHUB = .*$/API_TAXHUB = '${my_url}taxhub\/api'/g" config/geonature_config.toml
  sed -i "s/DEFAULT_LANGUAGE = .*$/DEFAULT_LANGUAGE = '${default_language}'/g" config/geonature_config.toml
  sed -i "s/LOCAL_SRID = .*$/LOCAL_SRID = '${srid_local}'/g" config/geonature_config.toml
else
  echo "Le fichier de configuration existe déjà"
fi

cd backend


# Installation du virtual env
# Suppression du venv s'il existe
if [ -d 'venv/' ]
then
  echo "Suppression du virtual env existant..."
  sudo rm -rf venv
fi

if [[ $python_path ]]; then
  echo "Installation du virtual env..."
  python3 -m virtualenv -p $python_path venv
else
  python3 -m virtualenv venv
fi

echo "Activation du virtual env..."
source venv/bin/activate
echo "Installation des dépendances Python..."
pip install --upgrade pip
pip install -r requirements.txt
if [[ $MODE == "dev" ]]
then
  pip install -r requirements-dev.txt
fi


echo "Création des commandes 'geonature'..."
python ${BASE_DIR}/geonature_cmd.py install_command
echo "Création de la configuration du frontend depuis 'config/geonature_config.toml'..."
geonature generate_frontend_config --conf-file ${BASE_DIR}/config/geonature_config.toml --build=false

# Lancement de l'application
echo "Configuration de l'application api backend dans supervisor..."
DIR=$(readlink -e "${0%/*}")
sudo -s cp geonature-service.conf /etc/supervisor/conf.d/
sudo -s sed -i "s%APP_PATH%${DIR}%" /etc/supervisor/conf.d/geonature-service.conf
sudo -s sed -i "s%ROOT_DIR%${BASE_DIR}%" /etc/supervisor/conf.d/geonature-service.conf


echo "Lancement de l'application api backend..."
sudo -s supervisorctl reread
sudo -s supervisorctl reload

#création d'un fichier rotation des logs
sudo cp $DIR/log_rotate /etc/logrotate.d/geonature
sudo -s sed -i "s%APP_PATH%${BASE_DIR}%" /etc/logrotate.d/geonature
sudo logrotate -f /etc/logrotate.conf


# Frontend installation
# Node and npm installation
echo "Installation de node et npm"
cd ../frontend  

# nvm install
nvm use

echo " ############"
echo "Installation des paquets npm"
npm ci --only=prod

# lien symbolique vers le dossier static du backend (pour le backoffice)
ln -s ${BASE_DIR}/frontend/node_modules ${BASE_DIR}/backend/static

# Creation du dossier des assets externes
mkdir src/external_assets

# Copy the custom components
echo "Création des fichiers de customisation du frontend..."
if [ ! -f src/custom/custom.scss ]; then
  cp src/custom/custom.scss.sample src/custom/custom.scss
fi

if [ ! -f src/custom/components/footer/footer.component.ts ]; then
  cp src/custom/components/footer/footer.component.ts.sample src/custom/components/footer/footer.component.ts
fi
if [ ! -f src/custom/components/footer/footer.component.html ]; then
  cp src/custom/components/footer/footer.component.html.sample src/custom/components/footer/footer.component.html
fi
if [ ! -f src/custom/components/introduction/introduction.component.ts ]; then
  cp src/custom/components/introduction/introduction.component.ts.sample src/custom/components/introduction/introduction.component.ts
fi
if [ ! -f src/custom/components/introduction/introduction.component.html ]; then
  cp src/custom/components/introduction/introduction.component.html.sample src/custom/components/introduction/introduction.component.html
fi


# Generate the tsconfig.json
geonature generate_frontend_tsconfig
# Generate the src/tsconfig.app.json
geonature generate_frontend_tsconfig_app
# Generate the modules routing file by templating
geonature generate_frontend_modules_route

# Retour à la racine de GeoNature
cd ../
my_current_geonature_directory=$(pwd)

# Installation du module Occtax et OccHab
geonature install_gn_module $my_current_geonature_directory/contrib/occtax /occtax --build=false

if [ "$install_module_occhab" = true ];
  then
  geonature install_gn_module $my_current_geonature_directory/contrib/gn_module_occhab /occhab --build=false
fi

if [ "$install_module_validation" = true ];
  then
    geonature install_gn_module $my_current_geonature_directory/contrib/gn_module_validation /validation --build=false
fi

echo "Désactiver le virtual env"
deactivate

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion


if [[ $MODE != "dev" ]]
then
  cd frontend
  echo "Build du frontend..."
  npm rebuild node-sass --force
  npm run build
fi



