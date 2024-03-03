# Tracker

Tracker is a (in development) open-source finance tracking software. It aims to provide a clear shot of your financial life by aggregating multiple bank account, brokers, assets, etc. in a single place.  

This is a modularized Laravel application. By going into the `src` directory, you're going to find all the available modules.  
If you wish to contribute, see if a related module already exists, or create a new one. Don't worry too much about folder structure — we can figure that out later.  

Although there's not a proper roadmap yet, [here's a Lucidchart](https://lucid.app/lucidchart/51fe9315-893a-45c5-9e59-a3eaa2e14b75/edit?page=0_0&invitationId=inv_289cc0d4-0cb5-4f73-a59e-474dc08b4ef6#) list of interesting features that are scheduled or in development:

## Exchange Module
The exchange module deals with everything related to equities. So it's responsible for keeping the price of all assets, such as stocks and crypto coins, up to date, and also managing a user's portfolio.  
The module has two main features right now:
- Asset: responsible for tracking historical prices and ingesting data about stocks, REITs, crypto coins, etc
- Portfolio: responsible for tracking a user's broker accounts, investments, trades (both buy and sell sides), and building daily projections of a user's position on every asset (stock, crypto) based on their previous transactions

## Bank Module 
(We might need a better name for this one).

This module deals with everything related to checking and savings accounts — so simpler transactions, as we're not tracking an asset. It's just an immutable ledger where we can build the account's balance as a projection of the transactions.

## Physical Assets Module

