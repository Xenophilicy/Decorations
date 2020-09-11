# Decorations
[![Poggit Decorations](https://poggit.pmmp.io/shield.state/Decorations)](https://poggit.pmmp.io/p/Decorations)
[![HitCount](http://hits.xenoservers.net:4000/Xenophilicy/Decorations.svg)](http://hits.xenoservers.net:4000)
[![Discord Chat](https://img.shields.io/discord/490677165289897995.svg)](https://discord.xenoservers.net)

# [![Xenophilicy](https://file.xenoservers.net/Resources/GitHub-Resources/decorations/screenshot.png)]()

## Information
With this plugin you can allow your players to purchase and spawn in custom geometry entities! Everything is configurable in the `decorations.json` config file including price, spawn limits, and entity scale!

### [Click here to download Decorations from Poggit](https://poggit.pmmp.io/p/Decorations/)

***

### Usage
Use `/deco` to access the main interface. From there you can enter the shop or view your `archived decorations`. By selecting an item in your `archive`, you have the option to sell or spawn the decoration. In the shop, you can select what category you'd like to browse. Once you pick a category, choose an item to purchase and proceed to the pre-purchase form. The pre-purchase form is where you can choose how many to buy, but also choose where you'd like the item to be exported to once you purchase it (inventory or `decoration archive`). Once bought, you can spawn it by tapping the item on the block of where you want it to be. You have the ability, as the decoration owner, to view the decoration options by hitting it. This screen allows you to sell, `archive`, and pick up the decoration for easier transport or movement adjustments.

***

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

## Credits
* [FiberglassCivic](https://github.com/95CivicSi/) (Helped with example custom geometry)
* [Xenophilicy](https://github.com/Xenophilicy/)
