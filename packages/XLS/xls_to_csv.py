#!/usr/bin/env python
# -*- coding: utf-8 -*-

import csv
import os
import imp
import sys

def check_module(mod_name):
    try:
        imp.find_module(mod_name)
        return True
    except ImportError:
        return False

if __name__ == "__main__":
    if not check_module('xlrd'):
        sys.stderr.write('Module %s not found!\n' % mod_name)
        sys.exit(1)
    else:
        import xlrd

    if len(sys.argv) == 2:
        xls_file, csv_path = sys.argv[1], '.'
    elif len(sys.argv) == 3:
        xls_file, csv_path = sys.argv[1:]
    else:
        sys.stderr.write('Missed operand. Usage: ./xls_to_csv.py source_file [destination_path]\n')
        sys.exit(2)

    if not os.path.isfile(xls_file):
        sys.stderr.write('Source file %s not found!\n' % xls_file)
        sys.exit(3)
    elif not os.path.isdir(csv_path):
        sys.stderr.write('Destination directory %s not found!\n' % csv_path)
        sys.exit(4)

    workbook = xlrd.open_workbook(xls_file)
    all_worksheets = workbook.sheet_names()
    i = 1
    for worksheet_name in all_worksheets:
        worksheet = workbook.sheet_by_name(worksheet_name)
        number_str = str(i)
        temp_sheet_name = 'Sheet' + number_str  
        csv_file = open(''.join([csv_path,'/',temp_sheet_name,'.csv']), 'wb')
        wr = csv.writer(csv_file, quoting=csv.QUOTE_ALL)
        for row_num in xrange(worksheet.nrows):
            wr.writerow([unicode(entry).encode("utf-8") for entry in worksheet.row_values(row_num)])
        i += 1
        csv_file.close()

    sys.exit(0)
