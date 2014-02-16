import mysql.connector
input_file = open("R_MF_CB.txt","r+")

con = mysql.connector.connect(user='robera', password='password',
                              host='localhost',
                              database='cruiser_app')

cursor = con.cursor()							  
##							  
add_dummy= ("INSERT INTO cb_mf (Dummy) VALUES ('%s')") 
##


data_dummy = ('1')

	

def time_slot(input_time):
        '''takes in a time xa xp where x is the time and p/a 
        stands for AM and PM, and outputs the time_slot this 
        particular time has to go into'''
        the_time = input_time.lstrip().rstrip()

        if the_time[-1] == "a":
                #then we are in the 0-12 range
                h_m = the_time.split(":")
                hour = h_m[0]
                minute = h_m[1]
                minute = minute[:-1]
                if hour == "12": 
                        out_hour = "24"
                        
                else:
                        out_hour = hour
                return out_hour+":"+minute
        else:
                #we are in the 12-24 range
                h_m = the_time.split(":")
                hour = h_m[0]
                minute = h_m[1]
                minute = minute[:-1]
                if hour == "12":
                        out_hour = "12"
                else:
                        out_hour = str(int(hour) + 12)
                        
                
                return out_hour+":"+minute	
	
		
	
	
#----------this is setting the rows for the routing table
for i in range(48):
        command = add_dummy%data_dummy
        print command
        cursor.execute(command)

add_time = ("UPDATE cb_mf SET %s = '%s' WHERE timeslot = %s")
#---------this is to set the routing table filled with the appropriate times 
for line in input_file.readlines():
        line = line.lstrip().rstrip()
        arr = line.split()
        place = arr[1]
        for time_no in range(2,len(arr)):
                ts = time_slot(arr[time_no])
				
                ts_h_m = ts.split(":")
                ts_h = int(ts_h_m[0])
                ts_m = int(ts_h_m[1])
                #this is where we figure out the timeslot where the time has to be placed
                if ts_m >= 30:
                        timeslot = ts_h * 2
                else:
                        timeslot = ( ts_h *2 ) - 1 
                
                new_entry = add_time%(place,ts,timeslot)
                print new_entry
                cursor.execute(new_entry)
		    




##cursor.execute("INSERT INTO jersons(Firstname) VALUES('DOG')")
##cursor.execute("SELECT * FROM jersons")
##res = cursor.fetchall()
##
##for outrow in res:
##    print outrow
##
##
con.commit()
##
cursor.close()
##							  
con.close()
