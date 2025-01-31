FROM centos:7

# See https://help.pentaho.com/Documentation/9.1/Setup/Prepare_your_Linux_environment_for_an_archive_install

RUN adduser -m pentaho \
    && mkdir -p /home/pentaho/.pentaho /home/pentaho/pentaho/server \
    && chown -R pentaho:pentaho /home/pentaho

RUN yum -y install zip unzip

# Install Oracle Java JRE

COPY --chown=pentaho:pentaho assets /tmp
USER pentaho
RUN cd /home/pentaho && tar zxf /tmp/server-jre-8u271-linux-x64.tar.gz && unzip /tmp/pentaho-server-ce-9.1.0.0-324.zip

# java -jar installer.jar -console
# export JAVA_HOME=/home/pentaho/jdk1.8.0_271
# export PENTAHO_JAVA_HOME=/home/pentaho/jdk1.8.0_271

# See https://help.pentaho.com/Documentation/9.1/Setup/Use_MySQL_as_your_repository_database_(Archive_installation)

