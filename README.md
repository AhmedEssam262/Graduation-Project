<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<<<<<<< HEAD
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
<<<<<<< HEAD
=======

>>>>>>> 7dfb7438a3eec20bf6dc07b3012cc3d754b74ad7
=======
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
>>>>>>> 1f2f309 (after installing needed packages)
