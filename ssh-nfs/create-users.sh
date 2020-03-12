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
    SSHDIR=/home/$username/.ssh
    mkdir $SSHDIR
    cat $file > $SSHDIR/authorized_keys
    chown -R $username:$username $SSHDIR
    chmod 0700 $SSHDIR
    chmod 0600 $SSHDIR/authorized_keys
done
