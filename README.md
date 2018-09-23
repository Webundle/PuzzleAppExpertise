# Puzzle App Expertise Bundle
**=========================**

Puzzle app expertise


### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

`composer require webundle/puzzle-app-expertise`

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
{
    $bundles = array(
    // ...

    new Puzzle\App\ExpertiseBundle\PuzzleAppExpertiseBundle(),
                    );

 // ...
}

 // ...
}
```

### Step 3: Register the Routes

Load the bundle's routing definition in the application (usually in the `app/config/routing.yml` file):

# app/config/routing.yml
```yaml
puzzle_app:
        resource: "@PuzzleAppExpertiseBundle/Resources/config/routing.yml"
```


### Step 4: Configure Bundle

Then, configure bundle by adding it to the list of registered bundles in the `app/config/config.yml` file of your project under:

```yaml
# Puzzle App Expertise
puzzle_app_expertise:
    title: expertise.title
    description: expertise.description
    icon: expertise.icon
    templates:
        service:
            list: 'AppBundle:Expertise:list_services.html.twig'
            show: 'AppBundle:Expertise:service.html.twig'
        project:
            list: 'AppBundle:Expertise:list_projects.html.twig'
            show: 'AppBundle:Expertise:project.html.twig'
        staff:
            list: 'AppBundle:Expertise:list_staffs.html.twig'
            show: 'AppBundle:Expertise:staff.html.twig'
        partner:
            list: 'AppBundle:Expertise:list_partners.html.twig'
        testimonial:
            list: 'AppBundle:Expertise:list_testimonials.html.twig'
            show: 'AppBundle:Expertise:testimonial.html.twig'
        faq:
            list: 'AppBundle:Expertise:list_faqs.html.twig'
            show: 'AppBundle:Expertise:faq.html.twig'
```