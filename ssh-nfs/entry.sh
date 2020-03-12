#!/bin/sh -e
#
# Set up NFS mount and SSH server

# Create users

/usr/local/bin/create-users.sh

# Required for NFS
rpc.statd &
rpcbind -f &

# Set up mount point

MOUNTPOINT=${MOUNTPOINT:-/mnt}

if [ ! -d $MOUNTPOINT ]; then
    mkdir -p $MOUNTPOINT
fi

if [ -n "$MOUNT_OPTIONS" ]; then
    MOUNT_OPTIONS="-o $MOUNT_OPTIONS"
fi

mount -t nfs $MOUNT_OPTIONS $SERVER:$SHARE $MOUNTPOINT
mount | grep nfs

/usr/sbin/sshd -D
