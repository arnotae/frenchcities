#!/usr/bin/env python
#-*- coding:utf-8 -*-

"""Convertie le fichier csv en script sql

...
"""

import csv
import codecs
import cStringIO


__author__ = "Julien Chanseaume"
__version__ = "1.0"
__email__ = "info@bibichette.com"


def perform():

    lines = []
    regions = {}
    departements = {}
    rownum = 0
    query = u"INSERT INTO ville (article, nom, cp) VALUES ('%s', '%s', '%s');\n"

    def escape(x): return x.replace("'", "''")
    
    csvReader = unicode_csv_reader(open("france.csv"), delimiter=',',
        quotechar='"', quoting=csv.QUOTE_ALL)

    lines.append(u"\n\n/* Liste des Villes */\n\n")
    for row in csvReader:
        rownum = rownum + 1
        if rownum == 1:
            continue
        if len(row) == 0:
            continue

        # 0:code postal,1:insee,2:article,3:ville,4:ARTICLE,5:VILLE,6:libelle,
        #   7:region,8:nom region,9:dep,10:nom dep,11:latitude,12:longitude,
        #   13:soundex, 14:metaphone
        # print row[0]
        lines.append(query % (escape(row[2]), escape(row[3]), row[0]))

        if not regions.has_key(row[8]):
            regions[row[7]] = (row[7], row[8])

        if not departements.has_key(row[10]):
            departements[row[9]] = (row[9], row[10], row[7])


    lines.append(u"\n\n/* Liste des Regions */\n\n")
    for region in regions.values():
        lines.append(u"INSERT INTO region (id, nom) VALUES ('%s', '%s');\n" % \
            (region[0], escape(region[1])))

    lines.append(u"\n\n/* Liste des Departements */\n\n")
    for departement in departements.values():
        lines.append(u"INSERT INTO departement (id, nom, reg) VALUES ('%s', '%s', '%s');\n" % \
            (departement[0], escape(departement[1]), departement[2]))

    with codecs.open("france-2010.sql","wb","utf-8") as f:
        f.writelines(lines)



def utf_8_encoder(unicode_csv_data):
    for line in unicode_csv_data:
        try:
            yield line.decode('utf-8').encode('utf-8')
        except:
            print repr(line)

def unicode_csv_reader(utf8_data, dialect=csv.excel, **kwargs):
    csv_reader = csv.reader(utf_8_encoder(utf8_data), dialect=dialect, **kwargs)
    for row in csv_reader:
        yield [unicode(cell, 'utf-8') for cell in row]

if __name__ == '__main__' :
    perform()

