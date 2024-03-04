#!/usr/bin/env sh

# FILENAME: count-sudo-sessions.sh
# AUTHOR: Zachary Krepelka
# DATE: Monday, January 15th, 2024

grep 'sudo:session' /var/log/auth.log |
grep opened | wc -l | tr -d '\n'
