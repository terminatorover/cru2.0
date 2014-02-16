import mysql.connector
input_file = open("R_MF_CA.txt","r+")

con = mysql.connector.connect(user='robera', password='password',
                              host='localhost',
                              database='cruiser_app')

cursor = con.cursor()							  
##							  
add_dummy= ("INSERT INTO ca_mf (Dummy) VALUES ('%s')") 
##

sel = "SELECT * FROM ca_mf"
cursor.execute(sel)
res = cursor.fetchall()

for outrow in res:
        if outrow[3]!= None:
                print outrow[3]
con.commit()
##
cursor.close()
##							  
con.close()
