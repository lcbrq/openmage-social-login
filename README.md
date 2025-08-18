# LCB_SocialLogin

Simple Social Login module for OpenMage based on [SocialConnect](https://github.com/SocialConnect/auth) library.

### Usage

Configure providers within System -> Store -> Configuration -> LCBRQ -> Social Login

Add following code to your login and register templates:

```
<?= $this->getChildHtml('sociallogin') ?>
```
