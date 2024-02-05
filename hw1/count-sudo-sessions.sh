#!/usr/bin/env sh

# FILENAME: count-sudo-sessions.sh
# AUTHOR: Zachary Krepelka
# DATE: Monday, January 15th, 2024

grep 'session opened for user root' /var/log/auth.log | wc -l | tr -d '\n'

