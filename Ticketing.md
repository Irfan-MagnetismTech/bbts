- Ticket Create Client Link Select Should Show Client Details.
- SupportTicketController and NotifyClientController mail and sms should be tracked in db.
- NotifyClientController and PopWiseIssueController `cc` should be filtered for both `; and ,` through BbtsGlobalService.


```
Ticket accpetance is kind of a movement actually. **Why?** Because it change the responsible person for a specific ticket.
```

- Support Team Creation Layer will come from user Roles or user has roles but this level is just show case?

- Ticket List 

- FORWARD can only be to 3RD Layer Teams.
    (new BbtsGlobalService())->getThirdLayerSupportTeam();

- Ticket Close while opening

- Estimated Time in Custom Email. Where should we show it.

- Take Decision to whome should we send email. Specific Branches email or mail clients email.

- Report Fitler and SupportTicket Lists Date filter... should we filter based on created_at or complain_time

- Ticket Closing [Need to think about Feedback to Client and Feedback to BBTS as their may be reopen in future]

- Fix wxcel download. When Download excel for once, then click search (submit) it downloads the excel. as reportType is still in append 