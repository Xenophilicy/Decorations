# Decorations
[![Poggit Decorations](https://poggit.pmmp.io/shield.state/Decorations)](https://poggit.pmmp.io/p/Decorations)
[![HitCount](http://hits.xenoservers.net:4000/Xenophilicy/Decorations.svg)](http://hits.xenoservers.net:4000)
[![Discord Chat](https://img.shields.io/discord/490677165289897995.svg)](https://discord.xenoservers.net)

# [![Xenophilicy](http://file.xenoservers.net/Resources/GitHub-Resources/decorations/screenshot.png)]()

## Information
With this plugin you can allow your players to purchase and spawn in custom geometry entities using the Decorations shop UI! Everything is configurable in the `decorations.json` config file including price, spawn limits, entity scale, and more!

### [Click here to download Decorations from Poggit](https://poggit.pmmp.io/p/Decorations/)

### Enhancments or feature requests
Please see the current [TODO list](https://github.com/Xenophilicy/Decorations#TODO) for some things that are currently being fixed or added before requesting something be added so there aren't any duplicate or invalid issues being created.

***

## Usage
Use `/deco` to access the main interface. From there you can enter the shop or view your `archived decorations`. By selecting an item in your `archive`, you have the option to sell or spawn the decoration. In the shop, you can select what category you'd like to browse. Once you pick a category, choose an item to purchase and proceed to the pre-purchase form. The pre-purchase form is where you can choose how many to buy, but also choose where you'd like the item to be exported to once you purchase it (inventory or `decoration archive`). Once bought, you can spawn it by tapping the item on the block of where you want it to be. You have the ability, as the decoration owner, to view the decoration options by hitting it. This screen allows you to sell, `archive`, and pick up the decoration for easier transport or movement adjustments. You can also edit the entity's yaw and pitch along with fine tune the XYZ coodinates using sliders!

***

## Adding models
This plugin allows users like YOU to add your very own custom models and texures simply by dragging your files into the directory found at `/plugin_data/Decorations/decorations` and adding an entry into a category in the `decorations.json` file! The two files required to create an entity are the geometry JSON file, and the texture PNG file. Once you have acquired both of those and copied them to the correct directory, you can add them into the Decoration configuration file with the instructions below!

### JSON Configuration
Please see the default JSON file [here](https://github.com/Xenophilicy/Decorations/blob/master/resources/decorations.json) for a more detailed example of how categories and entries should be entered.
Here is the JSON file broken down into separate parts. 

Category name
```json
"dishes": {
```

Category format
```json
"format": "§dDishes",
```

Entity list
```json
"entities": [
```

Entry ID
```json
"id": "mug",
```

Geometry file name            
```json
"geometry": "mug.geo.json",
```

Geometry identifier
```json
"identifier": "geometry.mug",
```

Entity texture
```json
"texture": "mug.png"
```

Entity rotation
```json
"rotation": {
  "yaw": 30,
  "pitch": 0
},
```

Entity size
```json
"scale": 0.4,
```

Allowed size
```json
"scale-range": {
  "min": 0.1,
  "max": 2
},
```

Entry format
```json
"format": "§6Coffee mug",
```

Entity buy price
```json
"price": 20,
```

Entity spawn limit
```json
"limit": 3,
```

Entity name tag            
```json
"nametag": "§aDrink me!"
```

***

The following table is used to determine a key's optionality.

|      Key      | Optionality |  Default  |
|:-------------:|:-----------:|:---------:|
| Category name |   required  |     -     |
| Category name |   required  |     -     |
|  Entity list  |   required  |     -     |
|    Entry ID   |   required  |     -     |
|   File name   |   required  |     -     |
|   Identifier  |   required  |     -     |
|    Texture    |   requried  |     -     |
|    Rotation   |   optional  |  Player's |
|      Size     |   optional  |     1     |
|  Allowed size |   optional  |    None   |
|     Format    |   optional  |  Entry ID |
|     Price     |   optional  |  Free (0) |
|     Limit     |   optional  | Unlimited |
|    Nametag    |   optional  |    None   |

***

In the end, your JSON entry will look something like this:
```json
{
  "dishes": {
    "format": "§dDishes",
    "entities": [
      {
        "id": "mug",
        "model": {
          "geometry": "mug.geo.json",
          "identifier": "geometry.mug",
          "texture": "mug.png"
        },
        "rotation": {
          "yaw": 30,
          "pitch": 0
        },
        "scale": 0.4,
        "scale-range": {
          "min": 0.1,
          "max": 2
        },
        "format": "§6Coffee mug",
        "price": 20,
        "limit": 3,
        "nametag": "§aDrink me!"
      }
    ]
  }
}
```

***

### TODO
These are things that are planned or in-progress
- [ ] Fine tuning
    - [X] Add yaw/pitch control using the Deco UI
    - [X] Add default rotation to configuration
    - [ ] Allow for live yaw and pitch control using player attachment
    - [X] Enable vector tuning using the Deco UI (XYZ)
    - [X] Add a scale range in the configuration to allow players to customize entity size
- [ ] Glitches
    - [ ] Fix issues with owner spawning in models
- [ ] Allow commands to be executed when interacting with foreign decorations
- [ ] UXP
    - [X] Catch errors thrown by removed deocorations (from the decorations.json file)
    - [ ] Allow deocrations to be mass despawned for moderation (by type, ID, owner, etc.)

## Credits
* [FiberglassCivic](https://github.com/95CivicSi/) (Helped with example custom geometry)
* [Xenophilicy](https://github.com/Xenophilicy/)
