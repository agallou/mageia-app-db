#!/bin/sh
sed -i config/schema.yml -e 's/UNKNOWN/boolean/'
sed -i config/schema.yml -e 's/char(32)/char, size:32/'
