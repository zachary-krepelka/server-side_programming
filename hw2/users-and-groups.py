#!/usr/bin/python3

# FILENAME: users-and-groups.py
# AUTHOR: Zachary Krepelka
# DATE: Saturday, February 24th, 2024
# ABOUT: a homework assignment for my server-side programming class
# ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
# PATH: /usr/local/bin/users-and-groups.py

################################################################################

# This file is part of an assignment for my server-side programming class at
# Saint Francis University.  I reproduce the assignment's instructions below to
# provide context for the reader.
#
# 	Write an unprivileged Python script that exposes an HTTP
# 	API on localhost:3000
#
# 		Your script should respond to HTTP POST requests
#
# 		Your script should only respond with data given
# 		the proper username/password (test/abcABC123)
#
# 		Your script should have two methods, users and
# 		groups, that provide a list of your system's
# 		users and groups
#
# 		Methods are to be accessed via
# 		http://YOUR-IP/api/METHOD
#
# 		When you reboot your computer the Python script
# 		must automatically start and be accessible via
# 		the above URL
#
# 	Add your script (and any other necessary files) to your
# 	repo and submit your repo URL
#
# 	Example HTTP reply from the "users" method:
#
# 		{"0":"root","1":"daemon","2":"bin","3":"sys", ...

################################################################################

PAGE_NOT_FOUND_ERROR = (

	'Unknown request. '
	'Please POST your username and password '
	'to the appropriate URL.\n'
)

AUTHENTICATION_ERROR = (

	'Please provide a correct username and password '
	'to access this service.\n'
)

USERNAME = { 'key' : 'username', 'value' : 'test' }
PASSWORD = { 'key' : 'password', 'value' : 'abcABC123' }

NAME, ID = 0, 2 # no magic numbers

################################################################################

verify = lambda credential: (

	credential['key'] in request.form and
	request.form[credential['key']] == credential['value']
)

authorized = lambda: verify(USERNAME) and verify(PASSWORD)

catalog = lambda filename: (

	extract_dictionary(filename, ID, NAME, delimiter = ':')

	if authorized() else AUTHENTICATION_ERROR

)

def extract_dictionary(filename, key_column, value_column, *, delimiter = ','):

	"Extracts a dictionary from a file of delimiter-separated values"

	dictionary = dict()

	with open(filename, 'r') as file:
		for line in file:
			row = line.strip().split(delimiter)
			dictionary[row[key_column]] = row[value_column]

	return dictionary

################################################################################

from flask import Flask, request

app = Flask(__name__)

@app.route('/users', methods = ['POST'])

def users():

	"Provides a catalog of a Linux system's users"

	return catalog('/etc/passwd')

@app.route('/groups', methods = ['POST'])

def groups():

	"Provides a catalog of a Linux system's groups"

	return catalog('/etc/group')

@app.errorhandler(Exception)

def page_not_found(e):

	return PAGE_NOT_FOUND_ERROR

if __name__ == "__main__":

	app.run(host = '127.0.0.1', port = 3000)

################################################################################
