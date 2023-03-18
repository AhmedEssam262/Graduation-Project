<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Finished untill now
```
### * There is three APIs checkuser , Adduser, Login
### * Database needed untill this step
### * Needed Packages installed
```
<hr>

## <div style="color: firebrick">Authentication APIs</div>

###  http://127.0.0.1:8000/api/adduser       which needs this data
    {
      "data":
            {
            "about": "goood",
            "achievement":"nothing",
            "address": {"province": "giza", "city": "elsk", "street":"wahet-g"},
            "birth": "1990-02-07",
            "chospital": "Dar-tawfeeq",
            "email": "ahmedmohamed@gmail.com",
            "eyears": 6,
            "fees": 200,
            "gender": "male",
            "gyear": 1963,
            "images": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAA…Z6UIhG+nuzvxnerPm9m/kXOF4uyIbIQAAAABJRU5ErkJggg==", 
            "moreInf": true,
            "nickname": "ahmedmohamed",
            "password": "AhmedAhmed22",
            "phone": "01024352774",
            "prefix": "20",
            "salary": 3000,
            "specialty": "Neurology",
            "userType": "doctor",
            "username": "ahmed2222"
            }
    }

### http://127.0.0.1:8000/api/login
    {
        "data":
            {
                "password": "AhmedAhmed22",
                 "username": "ahmed22"
            }
    }
### http://127.0.0.1:8000/api/chkuname/Auth1
<br>
<hr>

### http://127.0.0.1:8000/api/doctors

### http://127.0.0.1:8000/api/profile/{username}

### http://127.0.0.1:8000/api/doctors/{username}


### http://127.0.0.1:8000/api//feedback/{username}

## <div style="color: firebrick">Booking and Scheduling APIs</div>
### http://127.0.0.1:8000/api/schedule/appointments

    {
        "data":{
            "date":"2023-3-17"
            ,
            "addedAppointments":[
                {
                "slotTime":"10:50 am",
                "appointmentType":"chat",
                "appointmentDuration":20000
                },
                {
                "slotTime":"11:50 am",
                "appointmentType":"chat",
                "appointmentDuration":20000
                },
                {
                "slotTime":"12:50 am",
                "appointmentType":"chat",
                "appointmentDuration":20000
                }
            ]
        }
    }
    
    
    
    {
        "data":{
            "date":"2023-3-17"
            ,
            "deletedAppointments":[
                "11:50 am"
            ]
        }
    }

### http://127.0.0.1:8000/api/book/appointment

    {
        "data":{
            "date":"2023-2-27",
            "bookedSlot":"9:00 AM",
            "doctorId":40
        }
    }
### http://127.0.0.1:8000/api/get/slots
    {
        "data":{
            "date":"2023-03-06",
            "doctorId":6
        }
    }

### http://127.0.0.1:8000/api/cancel/appointment?userid=6

    {
        "data":{
            "cancelFrom":"patient",
            "date":"2023-2-27",
            "bookedSlot":"11:00 AM",
            "doctorId":40
        }
    }

### http://127.0.0.1:8000/api/cancel/appointment?userid=6

    {
        "data":{
            "cancelFrom":"patient",
            "date":"2023-2-27",
            "bookedSlot":"11:00 AM",
        }
    }


### http://127.0.0.1:8000/api/get/appointments?date=2023-3-17
### http://127.0.0.1:8000/api/get/appointments?date=2023-3-17&doctor=true
