#!/bin/sh

### post-update.sh for Composer
# Copies composer asset files from ./vendor to ./public

# setup asset directory
mkdir -pv public/assets/vendor

# disable directory access
cp -n app/index.html public/assets/
cp -n app/index.html public/assets/vendor/


### Specific package handling

# JQuery
rm -rf public/assets/vendor/jquery
mkdir public/assets/vendor/jquery
cp vendor/components/jquery/jquery* public/assets/vendor/jquery/
cp -n app/index.html public/assets/vendor/jquery/

# Bootstrap
rm -rf public/assets/vendor/bootstrap
mkdir public/assets/vendor/bootstrap
cp -R vendor/twbs/bootstrap/dist/css/* public/assets/vendor/bootstrap/
cp -R vendor/twbs/bootstrap/dist/js/* public/assets/vendor/bootstrap/
cp -n app/index.html public/assets/vendor/bootstrap/

# Chart.js
rm -rf public/assets/vendor/chartjs
cp -R vendor/nnnick/chartjs/dist public/assets/vendor/chartjs
cp -n app/index.html public/assets/vendor/chartjs/

# Datatables
rm -rf public/assets/vendor/datatables
cp -R vendor/datatables/datatables/media public/assets/vendor/datatables
cp -n app/index.html public/assets/vendor/datatables/
cp vendor/peekleon/datatables-all/extensions/Buttons/css/* public/assets/vendor/datatables/css/
cp vendor/peekleon/datatables-all/extensions/Buttons/js/* public/assets/vendor/datatables/js/

# Dropzone.js
rm -rf public/assets/vendor/dropzone
mkdir public/assets/vendor/dropzone
cp vendor/enyo/dropzone/dist/min/* public/assets/vendor/dropzone
cp -n app/index.html public/assets/vendor/dropzone/

# FontAwesome
rm -rf public/assets/vendor/font-awesome
mkdir public/assets/vendor/font-awesome/
cp -R vendor/fortawesome/font-awesome/css public/assets/vendor/font-awesome/
cp -R vendor/fortawesome/font-awesome/webfonts public/assets/vendor/font-awesome/
cp -n app/index.html public/assets/vendor/font-awesome/
cp -n app/index.html public/assets/vendor/font-awesome/webfonts/

# SB Admin 2
rm -rf public/assets/vendor/sbadmin2
mkdir public/assets/vendor/sbadmin2
cp vendor/blackrockdigital/sb-admin-2/css/* public/assets/vendor/sbadmin2/
cp vendor/blackrockdigital/sb-admin-2/js/*.js public/assets/vendor/sbadmin2/
cp vendor/blackrockdigital/sb-admin-2/vendor/jquery-easing/*.js public/assets/vendor/jquery/
cp -n app/index.html public/assets/vendor/sbadmin2/
# also link out to public for sample views
rm -f public/sbadmin2
ln -s ../vendor/blackrockdigital/sb-admin-2 public/sbadmin2


### All done

exit 0
