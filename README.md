# Betting Pros

This PHP command line script for our code challenge

## Requirements

- PHP 8.2.*
- Composer dependencies installed (run `composer install`)

### Options

#### Required:
- `--provider`: Specifies the data provider class to use for fetching and processing data. Currently, the only available provider is:
    - `DraftKingsProvider`
- `--sport`: Specifies the type of sport to filter the data. Available sports types are:
    - NFL - National Football League
    - NBA - National Basketball Association
    - NHL - National Hockey League
    - MLB - Major League Baseball
- `--filename`: The filename of the JSON data to be processed. This file should be located in the `Data` directory of the script.

#### Optional:
- `--date`: Filters events to include only those occurring on the specified date in `YYYY-MM-DD` format.
- `--team`: Filters events to include only those involving the specified team name.

1. **Basic Usage**:
php parser.php --provider=DraftKings --sport=MLB --filename=data.json

2. **With Date Filter**:
   php parser.php --provider=DraftKings --sport=MLB --filename=DraftKings_MLB_gamelines.json --date=2024-04-20

3. **With Team Filter**:
   php parser.php --provider=DraftKings --sport=MLB --filename=DraftKings_MLB_gamelines.json --team="Brewers"



