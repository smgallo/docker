FROM centos:centos7
LABEL description="SSH with NFS" maintainer="Steve Gallo <z3gallo@yahoo.com>" credits="https://github.com/flaccid/docker-nfs-client"

RUN yum -y update; yum clean all
RUN yum -y install openssh-server passwd nfs-utils; yum clean all
#RUN useradd user \
#	&& echo -e "4fB5Rr9mgM2WRdtWHKQ\n4fB5Rr9mgM2WRdtWHKQ" | (passwd --stdin user)
RUN mkdir /var/run/sshd

RUN ssh-keygen -t rsa -f /etc/ssh/ssh_host_rsa_key -N '' 

# Create user accounts with ssh keys

#RUN mkdir /tmp/users
#COPY users /tmp/users
#ADD create-users.sh /tmp/create-users.sh
#RUN /tmp/create-users.sh
#RUN rm -rf /tmp/users /tmp/create-users.sh

# Key-only ssh
RUN sed -i -e 's/^PasswordAuthentication yes$/PasswordAuthentication no/' /etc/ssh/sshd_config

ADD create-users.sh /usr/local/bin/create-users.sh
ADD entry.sh /usr/local/bin/entry.sh
EXPOSE 22
ENTRYPOINT ["/usr/local/bin/entry.sh"]
