# Betting Pros

This PHP command line script for our code challenge

## Requirements

- PHP 8.2.*
- (Or Docker)

## Docker Setup

To use this script with Docker, ensure Docker is installed on your system. Then follow these steps to build and run the
application in a Docker container.

### Build the Docker Image

From the root of your project directory (where the Dockerfile is located), run:

```bash
docker build -t php-sports-parser .
```

### To run this script

```docker run --rm php-sports-parser --provider=DraftKings --sport=MLB --filename=DraftKings_MLB_gamelines.json [options]```

#### Required:

- `--provider`: Specifies the data provider class to use for fetching and processing data. Currently, the only available
  provider is:
    - `DraftKings`
- `--sport`: Specifies the type of sport to filter the data. Available sports types are:
    - NFL - National Football League
    - NBA - National Basketball Association
    - NHL - National Hockey League
    - MLB - Major League Baseball
- `--filename`: The filename of the JSON data to be processed. This file should be located in the `Data` directory of
  the script.

#### Optional:

- `--date`: Filters events to include only those occurring on the specified date in `YYYY-MM-DD` format.
- `--team`: Filters events to include only those involving the specified team name.

#### Usage
1. **Basic Usage**:
   docker run --rm php-sports-parser --provider=DraftKings --sport=MLB --filename=DraftKings_MLB_gamelines.json

2. **With Date Filter**:
   docker run --rm php-sports-parser --provider=DraftKings --sport=MLB --filename=DraftKings_MLB_gamelines.json --date=2024-04-20

3. **With Team Filter**:
   docker run --rm php-sports-parser --provider=DraftKings --sport=MLB --filename=DraftKings_MLB_gamelines.json --team="Brewers"



