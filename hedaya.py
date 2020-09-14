
import mysql.connector
import serial
from mysql.connector import Error
connection= mysql.connector.connect(
                     host="185.201.11.128",    # your host, usually localhost
                     user="u824583950_epilepsycare",         # your username
                     passwd="123456",  # your password
                     db="u824583950_epilepsycare")
def clean(L):
    newData=L[2:-5]
    #str 
    return newData

def write(W):
    if W == "":
        W='0'
        
    mySql_insert_query = "INSERT INTO test (reading) VALUES ("+W+")" 
    cursor = connection.cursor()
    cursor.execute(mySql_insert_query)
    connection.commit()
    print(cursor.rowcount, "Record inserted successfully into test table")
    cursor.close()
    
    mySql_insert_query = "UPDATE system SET temp=("+W+") WHERE id=0" 
    cursor = connection.cursor()
    cursor.execute(mySql_insert_query)
    connection.commit()
    print(cursor.rowcount, "Record inserted successfully into test table")
    cursor.close()

try:
    arduino = serial.Serial("COM3",timeout=1, baudrate=57600)
except:
    print("check port")
rawData=[]
count=0

while 1:
    rawData=str(arduino.readline())
    cleanData= clean(rawData)
    print(cleanData)
    write(cleanData)