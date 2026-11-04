#!/bin/bash 
yum -y update --security --exclude=kernel* >> /stage/scripts/initial_boot_update.log 
