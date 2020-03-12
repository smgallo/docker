#!/bin/sh
#
# Create users based on the mounted volume (-v ./users:/tmp/users)

if [ ! -d /tmp/users ]; then
    exit 1
fi

for file in `ls -1 /tmp/users/*.pub`; do
    username=`basename $file | sed 's/.pub$//'`
    echo "Creating ssh user $username"
    useradd $username
    mkdir /home/$username/.ssh
    cat $file > /home/$username/.ssh/authorized_keys
done
