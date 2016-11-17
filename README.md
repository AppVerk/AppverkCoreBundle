# AppverkCoreBundle
Starting bundle for appverk projects, based on SonataAdminBundle.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/27c97640-1144-43fc-9bce-314e0e4980b6/big.png)](https://insight.sensiolabs.com/projects/27c97640-1144-43fc-9bce-314e0e4980b6)
# Installation

Require the bundle with composer:

```
...
"require": {
        ...
        "app-verk/core-bundle": "^1.0"
    },
"repositories": [
        {
            "url": "https://github.com/AppVerk/CoreBundle.git",
            "type": "vcs"
        }
    ],
```

Enable the bundle in the AppKernel:
```
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Cube\CoreBundle\CubeCoreBundle(),
        // ...
    );
}
```

# Create entites classes

```
<?php

// AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Cube\CoreBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cube_core_user")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="cube_core_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
```

```
<?php
// AppBundle/Entity/Group.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseGroup as BaseGroup;

/**
 * @ORM\Entity
 * @ORM\Table(name="cube_core_user_group")
 */
class Group extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
```

```
<?php
// AppBundle/Entity/Media.php

namespace AppBundle\Entity;

use Cube\CoreBundle\Entity\Media as BaseMedia;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cube_core_media")
 */
class Media extends BaseMedia
{
}
```

```
<?php
// AppBundle/Entity/Category.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\ClassificationBundle\Entity\BaseCategory;

/**
 * @ORM\Entity(repositoryClass="Cube\CoreBundle\Repository\CategoryRepository")
 * @ORM\Table(name="cube_core_category")
 */
class Category extends BaseCategory
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}

```

```
<?php
// AppBundle/Entity/Tag.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cube\CoreBundle\Entity\Tag as BaseTag;

/**
 * @ORM\Entity
 * @ORM\Table(name="cube_core_tag")
 */
class Tag extends BaseTag
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
}

```

# Configuration

Add new file to your config directory: cube_parameters.yml

```
parameters:
    cube_core_entity_user: AppBundle\Entity\User
    cube_core_entity_group: AppBundle\Entity\Group
    cube_core_entity_media: AppBundle\Entity\Media
    cube_core_entity_category: AppBundle\Entity\Category
    cube_core_entity_tag: AppBundle\Entity\Tag
```

Add import files to main config file:
```
...
    - { resource: cube_parameters.yml }
    - { resource: '@CubeCoreBundle/Resources/config/main.yml' }
...
```

Now u are ready to go!
