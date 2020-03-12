# Dockerized SSH Server with NFS Client

Useful for making an NFS share available to users via key-only ssh and limiting exposure of the host system.

Based on [flaccid/docker-nfs-client](https://github.com/flaccid/docker-nfs-client)

## Build

Users are created at container startup by placing their public ssh key into the `users` directory in a file named for their user with a ".pub" suffix. For example, placing a public ssh key into `users/smgallo.pub` will create the `smgallo` user in the container when it is started.

```sh
$ docker build -t ssh-nfs-client .
```

## Run

The container must run in privileged mode in order to mount the NFS share. The directory containing user ssh keys must be mounted in the container at `/tmp/users` for users to be created at startup.

```sh
$ docker run -it --privileged=true --net=host -p 9022:22 -v ./users:/tmp/users -e SERVER=192.168.0.9 -e SHARE=/vol1/movies -e MOUNTPOINT=/mnt ssh-nfs-client
```

Runtime environment variables:
- `SERVER` - the hostname of the NFS server to connect to
- `SHARE` - the name of the NFS share to mount
- `MOUNTPOINT` - the mount point for the NFS share within the container (default: /mnt)
- `MOUNT_OPTIONS` - mount options to mount the NFS share with
