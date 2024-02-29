#!/usr/bin/env sh

# FILENAME: implement-project.sh
# AUTHOR: Zachary Krepelka
# DATE: Wednesday, February 28th, 2024
# ABOUT: a homework assignment for my server-side programming class
# ORIGIN: http://github.com/zachary-krepelka/server-side_programming.git

cp users-and-groups.conf /etc/apache2/sites-available/users-and-groups.conf
cp users-and-groups.py /usr/local/bin/users-and-groups.py
cp users-and-groups.service /etc/systemd/user/users-and-groups.service
