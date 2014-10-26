Front-end theme structure
=========================

This is a front end development structure aimed towards swapping the tedious tasks of everyday front end development for a more modular and task based system.

Some of the benifits of using this particular stucture are listed below:

  - **Gulp** allows us to setup tasks such as minifying/prefixing and many more.
  - **Compass** is a great tool it comes equipt with several mixins and makes sprites a blast by generating classes automaticly. 
  - **Bower** is an excelent package manager allows thirdparty dependencies to be added and removed quickly.
  - **Sass** allows us to write css quicker and offers a more structured solution to writing modular css.

Instalation
-----------

First things first, place this into a project of any kind, although it has been structured with wordpress theme development in mind it will work regardless. Once you have cloned this repo into your development environment you will need to run:

```sh
npm install
```

This will install all of the dependencies required for the structure to work correctly.

Next is to install bower:

```sh
bower install
```

This will add two common packages **Jquery & Bootstrap** by default however you can remove them with:

```sh
bower uninstall jquery
bower uninstall bootstrap-sass
```

remember if you plan to remove these, update the sass vendor/thirdparty.scss file by removing the @import "bootstrap".

Gulp
----
[Gulp] has a few commands which we will cover in this section.

**Default**

This will do everything from compiling compass, sass, minification, prefixing and notifying you of it's completion.

```sh
gulp
```

**Development**

The only difference with the development task is it will only update the uncompressed version of the css located in styles/css and skipping over the minified file for optimum speed and efficiency. This will then watch the sass files for any changes.

```sh
gulp dev
```

**Deployment**

This will fire all tasks and will not watch the file ideal for quick building and avoiding C^ on the task. 

```sh
gulp deploy
```

Compass
-------

[Compass] is a third party **Ruby Gem** this contains several mixins and offers a tool to deal with sprites and compile classes to go with them. this is included by default as it is extremly helpful however in the event you wouldn't like to use the libary simply remove the compass @import in sass/vendor/thirdparty.scss

Bower
----
[bower] has been setup with an **.bowerrc** config file which points the bower packages to install to resources/components

Version
----

0.1.0

License
----

MIT

[gulp]:http://gulpjs.com/
[compass]:http://compass-style.org/
[bower]:http://bower.io/
