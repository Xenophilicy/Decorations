# Decorations
[![Poggit Decorations](https://poggit.pmmp.io/shield.state/Decorations)](https://poggit.pmmp.io/p/Decorations)
[![HitCount](http://hits.dwyl.io/Xenophilicy/Decorations.svg)](http://hits.dwyl.io/Xenophilicy/Decorations)
[![Discord Chat](https://img.shields.io/discord/490677165289897995.svg)](https://discord.xenoservers.net)

# [![Xenophilicy](https://file.xenoservers.net/Resources/GitHub-Resources/decorations/screenshot.png)]()

## Information
With this plugin you can allow your players to purchase and spawn in custom geometry entites! Everything is configurable in the `decorations.json` config file including price, spawn limits, and entity scale!

## JSON Configuration
```json
{
  "dishes": {                           category name
    "format": "§dDishes",               category format
    "entities": [
      {
        "id": "mug",                    entry id
        "model": { 
          "geometry": "mug.geo.json",   geometry file name
          "identifier": "geometry.mug", geometry identifier
          "texture": "mug.png"          entity texture
        },
        "scale": 0.4,                   entity size
        "format": "§6Coffee mug",       entry format
        "price": 20,                    entity buy price
        "limit": 3,                     entity spawn limit
        "nametag": "§aDrink me!"        entity name tag
      }
    ]
  }
}
```

### [Click here to download Decorations from Poggit](https://poggit.pmmp.io/p/Decorations/)

***

## Credits
* [FiberglassCivic](https://github.com/95CivicSi/) (Helped with example custom geometry)
* [Xenophilicy](https://github.com/Xenophilicy/)
