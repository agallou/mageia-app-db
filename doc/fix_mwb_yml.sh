#!/bin/sh
sed -i config/schema.yml -e 's/UNKNOWN/boolean/'
sed -i config/schema.yml -e 's/char(32)/char, size:32/'
sed -i config/schema.yml -e 's/sf_guard_user_id:\s*integer/sf_guard_user_id: { type:integer, foreignTable: sf_guard_user, foreignReference: id, required: true, onDelete: cascade }/'
