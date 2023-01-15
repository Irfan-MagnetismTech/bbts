### Installation

```
composer install
cp .env.example .env
php artisan migrate
php artisan db:seed
```

### Notes
- ***Models***, ***Controllers*** and ***Routes*** should be placed according to **Module**.

### Business Info
Business information like `name`, `logo path`, `shortname` etc. should be added in `config/businessinfo.php` and this config should be used everywhere in the **ERP** inlcuding `pages`, `printables`, and `mails.`

### File System Information
Default `storage` => `storage/app/public`

When using **`storeAs`** or similar method where we need to explicitly give storage path, please use the above convention

### Branching
```
Project Repository
|
└──main
    |
    |
    └──jahangir/task-or-feature
    |   
    └──saleha/task-or-feature
    |   
    └──delowar/task-or-feature
    |   
    └──username*/task-or-feature
```

### Instruction from GM Mr. Hasan Md Shahriare
- Complete a task and then merge to main with assistance of Project Leader.



    
