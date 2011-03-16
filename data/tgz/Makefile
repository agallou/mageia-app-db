install:
	#Copie de l'ensemble des fichiers
	cp -v -R *[^Makefile$$] /

	ln -s -f /usr/share/mageia_app_db/symfony /usr/share/mageia_app_db/madb

	##Chmod sur le fichier de lancement
	chmod +x /usr/share/mageia_app_db/madb

	##Chmod sur le dossier cache
	chmod -R 777 /var/lib/cache/

	##Ajout du lien symbolique dans le dossier bin
	ln -s -f /usr/share/mageia_app_db/madb /usr/bin/madb

uninstall:
	rm -rf -v /usr/share/mageia_app_db
	rm -rf -v /etc/mageia_app_db
	rm -rf -v /var/cache/mageia_app_db
	rm -rf -v /var/log/mageia_app_db
