### Installation

```
composer update
cp .env.example .env
php artisan migrate
php artisan db:seed
```

### Notes

-   **_Models_**, **_Controllers_** and **_Routes_** should be placed according to **Laravel Module Package**.
-   Follow https://docs.laravelmodules.com/v9/introduction for **Laravel Module Package** usage.

### Module Naming Convention

-   **_Modules_** should be named in **singular** form.
-   **_Modules_** should be named in **PascalCase**.
-   **_Modules_** short formed name should be in **UPPERCASE**. Ex: `HRM` for `Human Resource Management`

### Global Development Services, APIs, Components
-  Use `ActionButton` component for action buttons and `ReportButton` component accordingly.

    ```
    <x:action-button :show="route('support-teams.show', ['support_team' => $team->id])" :edit="route('support-teams.edit', ['support_team' => $team->id])" :delete="route('support-teams.show', ['support_team' => $team->id])" />
    ```

- Use `CommonApiController` for Common APIs.
- Use `BbtsGlobalService` for global data retrieval.

### Business Info

Business information like `name`, `logo path`, `shortname` etc. should be added in `config/businessinfo.php` and this config should be used everywhere in the **ERP** inlcuding `pages`, `printables`, and `mails.`

### File System Information

Default `storage` => `storage/app/public`

When using **`storeAs`** or similar method where we need to explicitly give storage path, please use the above convention

### Email

Default `mail` views are published and updated to work with markdown and removed default logos and links. 
**Keep other updated if you work on these or create your own view file**

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
    └──jaber/task-or-feature
    |
    └──irfan/task-or-feature
    |
    └──username*/task-or-feature
```

### Fine Tuning
`Ticketing.md`
`ScmIrfan.md`

### Instruction from GM Mr. Hasan Md Shahriare

-   Complete a task and then merge to main with assistance of Project Leader.
