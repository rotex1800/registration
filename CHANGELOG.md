# Changelog

## What's Changed
* chore: use github changelog by @paulschuberth in https://github.com/rotex1800/registration/pull/52


**Full Changelog**: https://github.com/rotex1800/registration/compare/v0.7.0...v0.7.1

## What's Changed
* fix: inherit secrets to release worflow by @paulschuberth in https://github.com/rotex1800/registration/pull/54


**Full Changelog**: https://github.com/rotex1800/registration/compare/v0.7.1...v0.7.2

## What's Changed
* feat: Add views for fortify's password reset by @paulschuberth in https://github.com/rotex1800/registration/pull/63
* feat: allow rotex to review documents #57 by @paulschuberth in https://github.com/rotex1800/registration/pull/66


**Full Changelog**: https://github.com/rotex1800/registration/compare/v0.7.2...v0.8.0

## What's Changed
* fix: Actually use workflow input to determine deployment target by @paulschuberth in https://github.com/rotex1800/registration/pull/67


**Full Changelog**: https://github.com/rotex1800/registration/compare/v0.8.0...v0.8.1

## [0.9.0](https://github.com/rotex1800/registration/compare/v0.8.2...v0.9.0) (2022-10-10)


### Features

* improve input validation [#74](https://github.com/rotex1800/registration/issues/74) ([#75](https://github.com/rotex1800/registration/issues/75)) ([6c51cc9](https://github.com/rotex1800/registration/commit/6c51cc97701518e94d7509279d8dcb98b2b90a2b))


### Miscellaneous Chores

* Fix typos ([f75a933](https://github.com/rotex1800/registration/commit/f75a9332d2d125b8cd1889a8294dfaccc11fc326))
* Improve Explanations ([#78](https://github.com/rotex1800/registration/issues/78)) ([3b82f7b](https://github.com/rotex1800/registration/commit/3b82f7bcae5db6529ff28e02ff3d8a081fb5d7ee))

## [0.8.2](https://github.com/rotex1800/registration/compare/v0.8.1...v0.8.2) (2022-10-09)


### Bug Fixes

* add inputs context ([d30607c](https://github.com/rotex1800/registration/commit/d30607c03c18369f7609a4fe5fc97216552fb9e2))
* Properly escape output in test to cope with htmlspecial chars ([#72](https://github.com/rotex1800/registration/issues/72)) ([8cc80b8](https://github.com/rotex1800/registration/commit/8cc80b8304107b6daf9114486bd552e8cbbdbc1e))


### Miscellaneous Chores

* Add explanations ([#73](https://github.com/rotex1800/registration/issues/73)) ([a15b4d1](https://github.com/rotex1800/registration/commit/a15b4d1c87766219e88f8adbf815452ca2fafd1a))
* **ui:** Improve readability in registrations overview table ([#70](https://github.com/rotex1800/registration/issues/70)) ([0ae560d](https://github.com/rotex1800/registration/commit/0ae560dcc5a25c76ab584d4afde2629f1a6980d2))

## [0.7.0](https://github.com/rotex1800/registration/compare/v0.6.0...v0.7.0) (2022-10-08)


### Features

* Add deployment workflow ([#7](https://github.com/rotex1800/registration/issues/7)) ([5454083](https://github.com/rotex1800/registration/commit/5454083dcb6964e722b417e46e2dc87d67abdd39))
* Add Registration Form ([c739f61](https://github.com/rotex1800/registration/commit/c739f61d42df65765da0e730fc62e6c6bb64be58))
* Add remaining upload ([#22](https://github.com/rotex1800/registration/issues/22)) ([0558e57](https://github.com/rotex1800/registration/commit/0558e57957fc2cd2cf70c061e34e5989371029b6))
* Disassociate Documents and Info Models ([#19](https://github.com/rotex1800/registration/issues/19)) ([3cefbe9](https://github.com/rotex1800/registration/commit/3cefbe98cf6b6ee095357abedcf6b3bfdc310cf3))
* Registration overview ([#29](https://github.com/rotex1800/registration/issues/29)) ([5deae0f](https://github.com/rotex1800/registration/commit/5deae0f06b396cc5a4bbcb7ada6b3908bf19be81))
* Require email to be verified to access application ([6700fe3](https://github.com/rotex1800/registration/commit/6700fe3af24b7077a444edc5f9246f3ac5a4a34c))


### Bug Fixes

* call deploy workflow directly from release workflow ([68e6754](https://github.com/rotex1800/registration/commit/68e675406c35ffc3c0a7bc704ccbc3b3f498124c))
* call deploy workflow directly from release workflow ([#51](https://github.com/rotex1800/registration/issues/51)) ([1250e49](https://github.com/rotex1800/registration/commit/1250e49d4b08482bf7724fecb375b8558a3d6897))
* composer.lock contains all dependencies ([#45](https://github.com/rotex1800/registration/issues/45)) ([336c6ff](https://github.com/rotex1800/registration/commit/336c6ff5863987bfecb63e66ebb1cb0d0b0bfe58))
* **deploy:** Source user_bashrc before running script ([#15](https://github.com/rotex1800/registration/issues/15)) ([ab87cb5](https://github.com/rotex1800/registration/commit/ab87cb5a52821b5eecacc37da7898466f4687082))
* don't change package-lock.json as part of deploy ([b3fe3c2](https://github.com/rotex1800/registration/commit/b3fe3c25a40711e70ad9fe9469e1f6dc6cdc855f))
* Hide registration overview for non-rotex user ([964714f](https://github.com/rotex1800/registration/commit/964714f8018b54f1744ddee300f954e1cae98b93))
* Make faker available in release build ([#41](https://github.com/rotex1800/registration/issues/41)) ([91b63e3](https://github.com/rotex1800/registration/commit/91b63e3737f3af6c81d074bcfc55992ce04e9c9e))
* Move faker to release deps in composer.lock too ([#43](https://github.com/rotex1800/registration/issues/43)) ([031aa31](https://github.com/rotex1800/registration/commit/031aa315d05164f2d8513ba7a0d0dd14bdba0aeb))
* workflows names ([#8](https://github.com/rotex1800/registration/issues/8)) ([2a7f024](https://github.com/rotex1800/registration/commit/2a7f024e551047232b9f9fb5c25c087dceb2fa0c))


### Miscellaneous Chores

* Add script to prepare the dev environment ([#39](https://github.com/rotex1800/registration/issues/39)) ([2fb9f99](https://github.com/rotex1800/registration/commit/2fb9f99e715145fec00c3492af43bbb0474b2ff7))
* Add shellcheck ([#14](https://github.com/rotex1800/registration/issues/14)) ([f5c4fe6](https://github.com/rotex1800/registration/commit/f5c4fe63073454a9eb37fd1d1c305e43c0f8b192))
* **check:** Add actionlint ([b570927](https://github.com/rotex1800/registration/commit/b570927586ffc06e45c1775ff59c007c7671f9e7))
* **check:** Add actionlint ([#16](https://github.com/rotex1800/registration/issues/16)) ([33c9adb](https://github.com/rotex1800/registration/commit/33c9adbc92c15e957060b07d6d6d329e6c2d2f6b))
* **check:** move gitleaks scan to check workflow ([5acf9a4](https://github.com/rotex1800/registration/commit/5acf9a438b2f6a3fbc3b6443e7c2bf5b4f602eee))
* **check:** move gitleaks scan to check workflow ([#18](https://github.com/rotex1800/registration/issues/18)) ([6fd2e94](https://github.com/rotex1800/registration/commit/6fd2e94d5ea0ea4b8d3ea36f0ff86bf200544aee))
* **check:** remove explicit name ([1417403](https://github.com/rotex1800/registration/commit/1417403d861ff542717f43d9f61116acf30ba4bd))
* **deploy:** Display url ([02176a7](https://github.com/rotex1800/registration/commit/02176a7c0ee76b35fcb87bdfe8393d6a4b2e2091))
* **deps:** bump axios from 0.27.2 to 1.0.0 ([64f0e9b](https://github.com/rotex1800/registration/commit/64f0e9b088391fe0c5b83229ea208b0159145c46))
* **deps:** bump axios from 0.27.2 to 1.0.0 ([#23](https://github.com/rotex1800/registration/issues/23)) ([dd812ef](https://github.com/rotex1800/registration/commit/dd812ef3f2ed73cbfbc3c224261e7f7126ecb54d))
* **deps:** bump axios from 1.0.0 to 1.1.0 ([e001eaa](https://github.com/rotex1800/registration/commit/e001eaa3fa207c50e4bd3fa2dddab69c39632a89))
* **deps:** bump axios from 1.0.0 to 1.1.0 ([#32](https://github.com/rotex1800/registration/issues/32)) ([3bfe367](https://github.com/rotex1800/registration/commit/3bfe367a01a1157172a6f6d24b2aadf64440b037))
* **deps:** bump axios from 1.1.0 to 1.1.2 ([c422f17](https://github.com/rotex1800/registration/commit/c422f171461a56472a54768c2e923a0739eab03e))
* **deps:** bump axios from 1.1.0 to 1.1.2 ([#35](https://github.com/rotex1800/registration/issues/35)) ([742b733](https://github.com/rotex1800/registration/commit/742b733357db1ef7d6130c8be213a7fc16223cee))
* **deps:** Bump laravel-vite-plugin from 0.5.4 to 0.6.1 ([#4](https://github.com/rotex1800/registration/issues/4)) ([bb48127](https://github.com/rotex1800/registration/commit/bb481274a433076e594724d86aa49a1a7d001a0a))
* **deps:** Bump laravel/dusk from 6.25.2 to 7.1.1 ([#5](https://github.com/rotex1800/registration/issues/5)) ([42e81e9](https://github.com/rotex1800/registration/commit/42e81e976c1d6b2bf66f0e79730b1f2283fd74c4))
* **deps:** bump laravel/fortify from 1.13.3 to 1.13.4 ([2be90a2](https://github.com/rotex1800/registration/commit/2be90a2f488d67ba9f0c8671ab36b12bd91834e3))
* **deps:** bump laravel/fortify from 1.13.3 to 1.13.4 ([#27](https://github.com/rotex1800/registration/issues/27)) ([92d8cc3](https://github.com/rotex1800/registration/commit/92d8cc3b349f5b18279b1f8becd9e36b4dec375f))
* **deps:** bump laravel/framework from 9.33.0 to 9.34.0 ([fad9840](https://github.com/rotex1800/registration/commit/fad9840125711489811caf93a19a42c36baabf51))
* **deps:** bump laravel/framework from 9.33.0 to 9.34.0 ([#25](https://github.com/rotex1800/registration/issues/25)) ([7bf45a2](https://github.com/rotex1800/registration/commit/7bf45a247d11c4855eb6c4574d3fb7eb7a5f854c))
* **deps:** bump laravel/sail from 1.16.1 to 1.16.2 ([62cd444](https://github.com/rotex1800/registration/commit/62cd44493a00bb28ee28df1f11ccde74f1ea32c1))
* **deps:** bump laravel/sail from 1.16.1 to 1.16.2 ([#24](https://github.com/rotex1800/registration/issues/24)) ([f15729a](https://github.com/rotex1800/registration/commit/f15729a1c4c3517d944d19a4b67bc9d6f61353ec))
* **deps:** bump nunomaduro/larastan from 2.2.0 to 2.2.1 ([38efaa3](https://github.com/rotex1800/registration/commit/38efaa33837aa28aaf4e3c8d375ab803356a960a))
* **deps:** bump nunomaduro/larastan from 2.2.0 to 2.2.1 ([#33](https://github.com/rotex1800/registration/issues/33)) ([bf0285b](https://github.com/rotex1800/registration/commit/bf0285b41cd864e277dbce06c4f7370ce1570426))
* **deps:** Bump postcss from 8.4.16 to 8.4.17 ([#6](https://github.com/rotex1800/registration/issues/6)) ([b386a70](https://github.com/rotex1800/registration/commit/b386a70e9757f9b72d839c2a115260b5cabbee21))
* **deps:** bump spatie/laravel-ignition from 1.5.0 to 1.5.1 ([6d15626](https://github.com/rotex1800/registration/commit/6d1562613385faaf77f518f07515a2e4683e7309))
* **deps:** bump spatie/laravel-ignition from 1.5.0 to 1.5.1 ([#26](https://github.com/rotex1800/registration/issues/26)) ([276b432](https://github.com/rotex1800/registration/commit/276b432d7f7a0fc92150331c203fa70726779168))
* **deps:** bump tailwindcss to 3.1.8 ([9d6f4d9](https://github.com/rotex1800/registration/commit/9d6f4d9e3c7151194909a4596b9c8e5b7092a311))
* **deps:** bump vite from 3.1.4 to 3.1.6 ([c88a498](https://github.com/rotex1800/registration/commit/c88a4984105c23a9f8d152c666dd6874d1974e6b))
* **deps:** bump vite from 3.1.4 to 3.1.6 ([#34](https://github.com/rotex1800/registration/issues/34)) ([dd7b2d0](https://github.com/rotex1800/registration/commit/dd7b2d0281ed376de685a675a0ec280b24edb710))
* Engage deploy.sh ([#13](https://github.com/rotex1800/registration/issues/13)) ([5fed68f](https://github.com/rotex1800/registration/commit/5fed68f730dc5e70e13d99eb9c5706e6f5af2548))
* **main:** release 0.1.2 ([2ec2937](https://github.com/rotex1800/registration/commit/2ec2937dcfaa64be048cb703ec59c4e8b0fc7b2f))
* **main:** release 0.1.2 ([#12](https://github.com/rotex1800/registration/issues/12)) ([dce179d](https://github.com/rotex1800/registration/commit/dce179d4f5321c7f0fab590abfd8cd5623d7a77a))
* **main:** release 0.1.3 ([09ea578](https://github.com/rotex1800/registration/commit/09ea5784b5edd9d74166e5b1ce219196f514fb17))
* **main:** release 0.1.3 ([#17](https://github.com/rotex1800/registration/issues/17)) ([b8789c4](https://github.com/rotex1800/registration/commit/b8789c485a5d957a2a17bdc294767eb8fc17f103))
* **main:** release 0.2.0 ([b452ffd](https://github.com/rotex1800/registration/commit/b452ffd775631b90ab7f5f2ffd8eb725d1505e03))
* **main:** release 0.2.0 ([#21](https://github.com/rotex1800/registration/issues/21)) ([4d62f25](https://github.com/rotex1800/registration/commit/4d62f25475c37c8b720cb501849b03b60ae20cff))
* **main:** release 0.3.0 ([4ce42c4](https://github.com/rotex1800/registration/commit/4ce42c4a61857d5d35dfa6bd050b4b5b94097f67))
* **main:** release 0.3.0 ([#28](https://github.com/rotex1800/registration/issues/28)) ([46ce642](https://github.com/rotex1800/registration/commit/46ce64259ecdaf5c4de9c80c0397635ac45c97aa))
* **main:** release 0.3.1 ([56e5769](https://github.com/rotex1800/registration/commit/56e576900c132e89c6872eded01ed2772b8d864c))
* **main:** release 0.3.1 ([#30](https://github.com/rotex1800/registration/issues/30)) ([edb04c7](https://github.com/rotex1800/registration/commit/edb04c788f47b680591ac9db6e0f476596fc9a45))
* **main:** release 0.4.0 ([df0e4cd](https://github.com/rotex1800/registration/commit/df0e4cd98645e71f42b3b54f843e3c384123739b))
* **main:** release 0.4.0 ([#36](https://github.com/rotex1800/registration/issues/36)) ([e1d16ec](https://github.com/rotex1800/registration/commit/e1d16ec9ca32d5d1eb687aad014161ff82421b74))
* **main:** release 0.5.0 ([8b69b9d](https://github.com/rotex1800/registration/commit/8b69b9d1e7a09e116b6dbb07b5ce2a7fdfe69963))
* **main:** release 0.5.1 ([c775cb7](https://github.com/rotex1800/registration/commit/c775cb7ba4ef0a1498f035ae070daae9d16e8af5))
* **main:** release 0.5.1 ([#42](https://github.com/rotex1800/registration/issues/42)) ([9c84641](https://github.com/rotex1800/registration/commit/9c84641f97dba876122206805f40a3873b8e244a))
* **main:** release 0.5.2 ([dbf9690](https://github.com/rotex1800/registration/commit/dbf96902ecacd0515fe4bf812210362e072c1b7c))
* **main:** release 0.5.2 ([#44](https://github.com/rotex1800/registration/issues/44)) ([a30132d](https://github.com/rotex1800/registration/commit/a30132d1929fd42ffdd0b3c6070f1fd643f895c9))
* **main:** release 0.5.3 ([82fd9a5](https://github.com/rotex1800/registration/commit/82fd9a5f3ea9f7f7a2cd0e6a1e4934565be0cade))
* **main:** release 0.5.3 ([#48](https://github.com/rotex1800/registration/issues/48)) ([5c4daaf](https://github.com/rotex1800/registration/commit/5c4daafbc839470d1e3e369d4d83ca511aaee80e))
* **main:** release 0.6.0 ([e720b60](https://github.com/rotex1800/registration/commit/e720b6056dc67faa46d272d5a8429e5f522f2fef))
* **main:** release 0.6.0 ([#49](https://github.com/rotex1800/registration/issues/49)) ([df35fe7](https://github.com/rotex1800/registration/commit/df35fe7d8316d8517bf461fe3c0badae41233ab3))
* **main:** release 1.0.0 ([baea969](https://github.com/rotex1800/registration/commit/baea969a83c06f46201b39cf49c1c58e8e137e26))
* **main:** release 1.0.0 ([#9](https://github.com/rotex1800/registration/issues/9)) ([6ad979e](https://github.com/rotex1800/registration/commit/6ad979ef622214f73785a53797263938c4824e6c))
* remove package name ([9329a38](https://github.com/rotex1800/registration/commit/9329a385a92199d26ca046b151ee2bae4f747052))
* remove package name ([#11](https://github.com/rotex1800/registration/issues/11)) ([4659c3b](https://github.com/rotex1800/registration/commit/4659c3b35f583c756c43ab4495804e36d8664efe))
* Run pint ([baefb24](https://github.com/rotex1800/registration/commit/baefb242918948b0c161b31bd55bd45bf37cdeae))
* Set default reviewers for dependabot PRs ([#31](https://github.com/rotex1800/registration/issues/31)) ([b0b07b9](https://github.com/rotex1800/registration/commit/b0b07b92f8341a80d01219b7abf4649a8b938258))
* Show version in Main Navigation ([#46](https://github.com/rotex1800/registration/issues/46)) ([1a70375](https://github.com/rotex1800/registration/commit/1a70375b31b593028e7eb607767180f4761abb96))
* update dependencies ([24f07a1](https://github.com/rotex1800/registration/commit/24f07a114f5af9c3f9f77d928e44f3be127d1715))
* update dependencies ([a2200d6](https://github.com/rotex1800/registration/commit/a2200d6e5dce6e28931b344304804137c28c3bf8))
* Use draft releases for sandbox deployment ([4a46f2c](https://github.com/rotex1800/registration/commit/4a46f2cb3a19c7cffa2b841c7d43cf84816cd848))
* Use draft releases for sandbox deployment ([#47](https://github.com/rotex1800/registration/issues/47)) ([7cfb0ab](https://github.com/rotex1800/registration/commit/7cfb0abcaa0af72e3e0b80720c511d51df87ff38))
* Use personal access token for release please action ([#10](https://github.com/rotex1800/registration/issues/10)) ([3095293](https://github.com/rotex1800/registration/commit/3095293b54452473943cd7705348ac908b9e8471))

## [0.6.0](https://github.com/rotex1800/registration/compare/v0.5.3...v0.6.0) (2022-10-08)


### Features

* Add deployment workflow ([#7](https://github.com/rotex1800/registration/issues/7)) ([5454083](https://github.com/rotex1800/registration/commit/5454083dcb6964e722b417e46e2dc87d67abdd39))
* Add Registration Form ([c739f61](https://github.com/rotex1800/registration/commit/c739f61d42df65765da0e730fc62e6c6bb64be58))
* Add remaining upload ([#22](https://github.com/rotex1800/registration/issues/22)) ([0558e57](https://github.com/rotex1800/registration/commit/0558e57957fc2cd2cf70c061e34e5989371029b6))
* Disassociate Documents and Info Models ([#19](https://github.com/rotex1800/registration/issues/19)) ([3cefbe9](https://github.com/rotex1800/registration/commit/3cefbe98cf6b6ee095357abedcf6b3bfdc310cf3))
* Registration overview ([#29](https://github.com/rotex1800/registration/issues/29)) ([5deae0f](https://github.com/rotex1800/registration/commit/5deae0f06b396cc5a4bbcb7ada6b3908bf19be81))
* Require email to be verified to access application ([6700fe3](https://github.com/rotex1800/registration/commit/6700fe3af24b7077a444edc5f9246f3ac5a4a34c))


### Bug Fixes

* composer.lock contains all dependencies ([#45](https://github.com/rotex1800/registration/issues/45)) ([336c6ff](https://github.com/rotex1800/registration/commit/336c6ff5863987bfecb63e66ebb1cb0d0b0bfe58))
* **deploy:** Source user_bashrc before running script ([#15](https://github.com/rotex1800/registration/issues/15)) ([ab87cb5](https://github.com/rotex1800/registration/commit/ab87cb5a52821b5eecacc37da7898466f4687082))
* don't change package-lock.json as part of deploy ([b3fe3c2](https://github.com/rotex1800/registration/commit/b3fe3c25a40711e70ad9fe9469e1f6dc6cdc855f))
* Hide registration overview for non-rotex user ([964714f](https://github.com/rotex1800/registration/commit/964714f8018b54f1744ddee300f954e1cae98b93))
* Make faker available in release build ([#41](https://github.com/rotex1800/registration/issues/41)) ([91b63e3](https://github.com/rotex1800/registration/commit/91b63e3737f3af6c81d074bcfc55992ce04e9c9e))
* Move faker to release deps in composer.lock too ([#43](https://github.com/rotex1800/registration/issues/43)) ([031aa31](https://github.com/rotex1800/registration/commit/031aa315d05164f2d8513ba7a0d0dd14bdba0aeb))
* workflows names ([#8](https://github.com/rotex1800/registration/issues/8)) ([2a7f024](https://github.com/rotex1800/registration/commit/2a7f024e551047232b9f9fb5c25c087dceb2fa0c))


### Miscellaneous Chores

* Add script to prepare the dev environment ([#39](https://github.com/rotex1800/registration/issues/39)) ([2fb9f99](https://github.com/rotex1800/registration/commit/2fb9f99e715145fec00c3492af43bbb0474b2ff7))
* Add shellcheck ([#14](https://github.com/rotex1800/registration/issues/14)) ([f5c4fe6](https://github.com/rotex1800/registration/commit/f5c4fe63073454a9eb37fd1d1c305e43c0f8b192))
* **check:** Add actionlint ([b570927](https://github.com/rotex1800/registration/commit/b570927586ffc06e45c1775ff59c007c7671f9e7))
* **check:** Add actionlint ([#16](https://github.com/rotex1800/registration/issues/16)) ([33c9adb](https://github.com/rotex1800/registration/commit/33c9adbc92c15e957060b07d6d6d329e6c2d2f6b))
* **check:** move gitleaks scan to check workflow ([5acf9a4](https://github.com/rotex1800/registration/commit/5acf9a438b2f6a3fbc3b6443e7c2bf5b4f602eee))
* **check:** move gitleaks scan to check workflow ([#18](https://github.com/rotex1800/registration/issues/18)) ([6fd2e94](https://github.com/rotex1800/registration/commit/6fd2e94d5ea0ea4b8d3ea36f0ff86bf200544aee))
* **check:** remove explicit name ([1417403](https://github.com/rotex1800/registration/commit/1417403d861ff542717f43d9f61116acf30ba4bd))
* **deploy:** Display url ([02176a7](https://github.com/rotex1800/registration/commit/02176a7c0ee76b35fcb87bdfe8393d6a4b2e2091))
* **deps:** bump axios from 0.27.2 to 1.0.0 ([64f0e9b](https://github.com/rotex1800/registration/commit/64f0e9b088391fe0c5b83229ea208b0159145c46))
* **deps:** bump axios from 0.27.2 to 1.0.0 ([#23](https://github.com/rotex1800/registration/issues/23)) ([dd812ef](https://github.com/rotex1800/registration/commit/dd812ef3f2ed73cbfbc3c224261e7f7126ecb54d))
* **deps:** bump axios from 1.0.0 to 1.1.0 ([e001eaa](https://github.com/rotex1800/registration/commit/e001eaa3fa207c50e4bd3fa2dddab69c39632a89))
* **deps:** bump axios from 1.0.0 to 1.1.0 ([#32](https://github.com/rotex1800/registration/issues/32)) ([3bfe367](https://github.com/rotex1800/registration/commit/3bfe367a01a1157172a6f6d24b2aadf64440b037))
* **deps:** bump axios from 1.1.0 to 1.1.2 ([c422f17](https://github.com/rotex1800/registration/commit/c422f171461a56472a54768c2e923a0739eab03e))
* **deps:** bump axios from 1.1.0 to 1.1.2 ([#35](https://github.com/rotex1800/registration/issues/35)) ([742b733](https://github.com/rotex1800/registration/commit/742b733357db1ef7d6130c8be213a7fc16223cee))
* **deps:** Bump laravel-vite-plugin from 0.5.4 to 0.6.1 ([#4](https://github.com/rotex1800/registration/issues/4)) ([bb48127](https://github.com/rotex1800/registration/commit/bb481274a433076e594724d86aa49a1a7d001a0a))
* **deps:** Bump laravel/dusk from 6.25.2 to 7.1.1 ([#5](https://github.com/rotex1800/registration/issues/5)) ([42e81e9](https://github.com/rotex1800/registration/commit/42e81e976c1d6b2bf66f0e79730b1f2283fd74c4))
* **deps:** bump laravel/fortify from 1.13.3 to 1.13.4 ([2be90a2](https://github.com/rotex1800/registration/commit/2be90a2f488d67ba9f0c8671ab36b12bd91834e3))
* **deps:** bump laravel/fortify from 1.13.3 to 1.13.4 ([#27](https://github.com/rotex1800/registration/issues/27)) ([92d8cc3](https://github.com/rotex1800/registration/commit/92d8cc3b349f5b18279b1f8becd9e36b4dec375f))
* **deps:** bump laravel/framework from 9.33.0 to 9.34.0 ([fad9840](https://github.com/rotex1800/registration/commit/fad9840125711489811caf93a19a42c36baabf51))
* **deps:** bump laravel/framework from 9.33.0 to 9.34.0 ([#25](https://github.com/rotex1800/registration/issues/25)) ([7bf45a2](https://github.com/rotex1800/registration/commit/7bf45a247d11c4855eb6c4574d3fb7eb7a5f854c))
* **deps:** bump laravel/sail from 1.16.1 to 1.16.2 ([62cd444](https://github.com/rotex1800/registration/commit/62cd44493a00bb28ee28df1f11ccde74f1ea32c1))
* **deps:** bump laravel/sail from 1.16.1 to 1.16.2 ([#24](https://github.com/rotex1800/registration/issues/24)) ([f15729a](https://github.com/rotex1800/registration/commit/f15729a1c4c3517d944d19a4b67bc9d6f61353ec))
* **deps:** bump nunomaduro/larastan from 2.2.0 to 2.2.1 ([38efaa3](https://github.com/rotex1800/registration/commit/38efaa33837aa28aaf4e3c8d375ab803356a960a))
* **deps:** bump nunomaduro/larastan from 2.2.0 to 2.2.1 ([#33](https://github.com/rotex1800/registration/issues/33)) ([bf0285b](https://github.com/rotex1800/registration/commit/bf0285b41cd864e277dbce06c4f7370ce1570426))
* **deps:** Bump postcss from 8.4.16 to 8.4.17 ([#6](https://github.com/rotex1800/registration/issues/6)) ([b386a70](https://github.com/rotex1800/registration/commit/b386a70e9757f9b72d839c2a115260b5cabbee21))
* **deps:** bump spatie/laravel-ignition from 1.5.0 to 1.5.1 ([6d15626](https://github.com/rotex1800/registration/commit/6d1562613385faaf77f518f07515a2e4683e7309))
* **deps:** bump spatie/laravel-ignition from 1.5.0 to 1.5.1 ([#26](https://github.com/rotex1800/registration/issues/26)) ([276b432](https://github.com/rotex1800/registration/commit/276b432d7f7a0fc92150331c203fa70726779168))
* **deps:** bump tailwindcss to 3.1.8 ([9d6f4d9](https://github.com/rotex1800/registration/commit/9d6f4d9e3c7151194909a4596b9c8e5b7092a311))
* **deps:** bump vite from 3.1.4 to 3.1.6 ([c88a498](https://github.com/rotex1800/registration/commit/c88a4984105c23a9f8d152c666dd6874d1974e6b))
* **deps:** bump vite from 3.1.4 to 3.1.6 ([#34](https://github.com/rotex1800/registration/issues/34)) ([dd7b2d0](https://github.com/rotex1800/registration/commit/dd7b2d0281ed376de685a675a0ec280b24edb710))
* Engage deploy.sh ([#13](https://github.com/rotex1800/registration/issues/13)) ([5fed68f](https://github.com/rotex1800/registration/commit/5fed68f730dc5e70e13d99eb9c5706e6f5af2548))
* **main:** release 0.1.2 ([2ec2937](https://github.com/rotex1800/registration/commit/2ec2937dcfaa64be048cb703ec59c4e8b0fc7b2f))
* **main:** release 0.1.2 ([#12](https://github.com/rotex1800/registration/issues/12)) ([dce179d](https://github.com/rotex1800/registration/commit/dce179d4f5321c7f0fab590abfd8cd5623d7a77a))
* **main:** release 0.1.3 ([09ea578](https://github.com/rotex1800/registration/commit/09ea5784b5edd9d74166e5b1ce219196f514fb17))
* **main:** release 0.1.3 ([#17](https://github.com/rotex1800/registration/issues/17)) ([b8789c4](https://github.com/rotex1800/registration/commit/b8789c485a5d957a2a17bdc294767eb8fc17f103))
* **main:** release 0.2.0 ([b452ffd](https://github.com/rotex1800/registration/commit/b452ffd775631b90ab7f5f2ffd8eb725d1505e03))
* **main:** release 0.2.0 ([#21](https://github.com/rotex1800/registration/issues/21)) ([4d62f25](https://github.com/rotex1800/registration/commit/4d62f25475c37c8b720cb501849b03b60ae20cff))
* **main:** release 0.3.0 ([4ce42c4](https://github.com/rotex1800/registration/commit/4ce42c4a61857d5d35dfa6bd050b4b5b94097f67))
* **main:** release 0.3.0 ([#28](https://github.com/rotex1800/registration/issues/28)) ([46ce642](https://github.com/rotex1800/registration/commit/46ce64259ecdaf5c4de9c80c0397635ac45c97aa))
* **main:** release 0.3.1 ([56e5769](https://github.com/rotex1800/registration/commit/56e576900c132e89c6872eded01ed2772b8d864c))
* **main:** release 0.3.1 ([#30](https://github.com/rotex1800/registration/issues/30)) ([edb04c7](https://github.com/rotex1800/registration/commit/edb04c788f47b680591ac9db6e0f476596fc9a45))
* **main:** release 0.4.0 ([df0e4cd](https://github.com/rotex1800/registration/commit/df0e4cd98645e71f42b3b54f843e3c384123739b))
* **main:** release 0.4.0 ([#36](https://github.com/rotex1800/registration/issues/36)) ([e1d16ec](https://github.com/rotex1800/registration/commit/e1d16ec9ca32d5d1eb687aad014161ff82421b74))
* **main:** release 0.5.0 ([8b69b9d](https://github.com/rotex1800/registration/commit/8b69b9d1e7a09e116b6dbb07b5ce2a7fdfe69963))
* **main:** release 0.5.1 ([c775cb7](https://github.com/rotex1800/registration/commit/c775cb7ba4ef0a1498f035ae070daae9d16e8af5))
* **main:** release 0.5.1 ([#42](https://github.com/rotex1800/registration/issues/42)) ([9c84641](https://github.com/rotex1800/registration/commit/9c84641f97dba876122206805f40a3873b8e244a))
* **main:** release 0.5.2 ([dbf9690](https://github.com/rotex1800/registration/commit/dbf96902ecacd0515fe4bf812210362e072c1b7c))
* **main:** release 0.5.2 ([#44](https://github.com/rotex1800/registration/issues/44)) ([a30132d](https://github.com/rotex1800/registration/commit/a30132d1929fd42ffdd0b3c6070f1fd643f895c9))
* **main:** release 0.5.3 ([82fd9a5](https://github.com/rotex1800/registration/commit/82fd9a5f3ea9f7f7a2cd0e6a1e4934565be0cade))
* **main:** release 0.5.3 ([#48](https://github.com/rotex1800/registration/issues/48)) ([5c4daaf](https://github.com/rotex1800/registration/commit/5c4daafbc839470d1e3e369d4d83ca511aaee80e))
* **main:** release 1.0.0 ([baea969](https://github.com/rotex1800/registration/commit/baea969a83c06f46201b39cf49c1c58e8e137e26))
* **main:** release 1.0.0 ([#9](https://github.com/rotex1800/registration/issues/9)) ([6ad979e](https://github.com/rotex1800/registration/commit/6ad979ef622214f73785a53797263938c4824e6c))
* remove package name ([9329a38](https://github.com/rotex1800/registration/commit/9329a385a92199d26ca046b151ee2bae4f747052))
* remove package name ([#11](https://github.com/rotex1800/registration/issues/11)) ([4659c3b](https://github.com/rotex1800/registration/commit/4659c3b35f583c756c43ab4495804e36d8664efe))
* Run pint ([baefb24](https://github.com/rotex1800/registration/commit/baefb242918948b0c161b31bd55bd45bf37cdeae))
* Set default reviewers for dependabot PRs ([#31](https://github.com/rotex1800/registration/issues/31)) ([b0b07b9](https://github.com/rotex1800/registration/commit/b0b07b92f8341a80d01219b7abf4649a8b938258))
* Show version in Main Navigation ([#46](https://github.com/rotex1800/registration/issues/46)) ([1a70375](https://github.com/rotex1800/registration/commit/1a70375b31b593028e7eb607767180f4761abb96))
* update dependencies ([24f07a1](https://github.com/rotex1800/registration/commit/24f07a114f5af9c3f9f77d928e44f3be127d1715))
* update dependencies ([a2200d6](https://github.com/rotex1800/registration/commit/a2200d6e5dce6e28931b344304804137c28c3bf8))
* Use draft releases for sandbox deployment ([4a46f2c](https://github.com/rotex1800/registration/commit/4a46f2cb3a19c7cffa2b841c7d43cf84816cd848))
* Use draft releases for sandbox deployment ([#47](https://github.com/rotex1800/registration/issues/47)) ([7cfb0ab](https://github.com/rotex1800/registration/commit/7cfb0abcaa0af72e3e0b80720c511d51df87ff38))
* Use personal access token for release please action ([#10](https://github.com/rotex1800/registration/issues/10)) ([3095293](https://github.com/rotex1800/registration/commit/3095293b54452473943cd7705348ac908b9e8471))

## [0.5.3](https://github.com/rotex1800/registration/compare/v0.5.2...v0.5.3) (2022-10-08)


### Miscellaneous Chores

* Use draft releases for sandbox deployment ([4a46f2c](https://github.com/rotex1800/registration/commit/4a46f2cb3a19c7cffa2b841c7d43cf84816cd848))
* Use draft releases for sandbox deployment ([#47](https://github.com/rotex1800/registration/issues/47)) ([7cfb0ab](https://github.com/rotex1800/registration/commit/7cfb0abcaa0af72e3e0b80720c511d51df87ff38))

## [0.5.2](https://github.com/rotex1800/registration/compare/v0.5.1...v0.5.2) (2022-10-08)


### Bug Fixes

* composer.lock contains all dependencies ([#45](https://github.com/rotex1800/registration/issues/45)) ([336c6ff](https://github.com/rotex1800/registration/commit/336c6ff5863987bfecb63e66ebb1cb0d0b0bfe58))
* Move faker to release deps in composer.lock too ([#43](https://github.com/rotex1800/registration/issues/43)) ([031aa31](https://github.com/rotex1800/registration/commit/031aa315d05164f2d8513ba7a0d0dd14bdba0aeb))


### Miscellaneous Chores

* Show version in Main Navigation ([#46](https://github.com/rotex1800/registration/issues/46)) ([1a70375](https://github.com/rotex1800/registration/commit/1a70375b31b593028e7eb607767180f4761abb96))

## [0.5.1](https://github.com/rotex1800/registration/compare/v0.5.0...v0.5.1) (2022-10-08)


### Bug Fixes

* Make faker available in release build ([#41](https://github.com/rotex1800/registration/issues/41)) ([91b63e3](https://github.com/rotex1800/registration/commit/91b63e3737f3af6c81d074bcfc55992ce04e9c9e))

## [0.5.0](https://github.com/rotex1800/registration/compare/v0.4.0...v0.5.0) (2022-10-08)


### Features

* Add Registration Form ([c739f61](https://github.com/rotex1800/registration/commit/c739f61d42df65765da0e730fc62e6c6bb64be58))
* Require email to be verified to access application ([6700fe3](https://github.com/rotex1800/registration/commit/6700fe3af24b7077a444edc5f9246f3ac5a4a34c))


### Bug Fixes

* don't change package-lock.json as part of deploy ([b3fe3c2](https://github.com/rotex1800/registration/commit/b3fe3c25a40711e70ad9fe9469e1f6dc6cdc855f))
* Hide registration overview for non-rotex user ([964714f](https://github.com/rotex1800/registration/commit/964714f8018b54f1744ddee300f954e1cae98b93))


### Miscellaneous Chores

* Add script to prepare the dev environment ([#39](https://github.com/rotex1800/registration/issues/39)) ([2fb9f99](https://github.com/rotex1800/registration/commit/2fb9f99e715145fec00c3492af43bbb0474b2ff7))
* Run pint ([baefb24](https://github.com/rotex1800/registration/commit/baefb242918948b0c161b31bd55bd45bf37cdeae))

## [0.4.0](https://github.com/rotex1800/registration/compare/v0.3.1...v0.4.0) (2022-10-08)


### Features

* Registration overview ([#29](https://github.com/rotex1800/registration/issues/29)) ([5deae0f](https://github.com/rotex1800/registration/commit/5deae0f06b396cc5a4bbcb7ada6b3908bf19be81))


### Miscellaneous Chores

* **deps:** bump axios from 1.1.0 to 1.1.2 ([c422f17](https://github.com/rotex1800/registration/commit/c422f171461a56472a54768c2e923a0739eab03e))
* **deps:** bump axios from 1.1.0 to 1.1.2 ([#35](https://github.com/rotex1800/registration/issues/35)) ([742b733](https://github.com/rotex1800/registration/commit/742b733357db1ef7d6130c8be213a7fc16223cee))

## [0.3.1](https://github.com/rotex1800/registration/compare/v0.3.0...v0.3.1) (2022-10-07)


### Miscellaneous Chores

* **deps:** bump axios from 0.27.2 to 1.0.0 ([64f0e9b](https://github.com/rotex1800/registration/commit/64f0e9b088391fe0c5b83229ea208b0159145c46))
* **deps:** bump axios from 0.27.2 to 1.0.0 ([#23](https://github.com/rotex1800/registration/issues/23)) ([dd812ef](https://github.com/rotex1800/registration/commit/dd812ef3f2ed73cbfbc3c224261e7f7126ecb54d))
* **deps:** bump axios from 1.0.0 to 1.1.0 ([e001eaa](https://github.com/rotex1800/registration/commit/e001eaa3fa207c50e4bd3fa2dddab69c39632a89))
* **deps:** bump axios from 1.0.0 to 1.1.0 ([#32](https://github.com/rotex1800/registration/issues/32)) ([3bfe367](https://github.com/rotex1800/registration/commit/3bfe367a01a1157172a6f6d24b2aadf64440b037))
* **deps:** bump laravel/fortify from 1.13.3 to 1.13.4 ([2be90a2](https://github.com/rotex1800/registration/commit/2be90a2f488d67ba9f0c8671ab36b12bd91834e3))
* **deps:** bump laravel/fortify from 1.13.3 to 1.13.4 ([#27](https://github.com/rotex1800/registration/issues/27)) ([92d8cc3](https://github.com/rotex1800/registration/commit/92d8cc3b349f5b18279b1f8becd9e36b4dec375f))
* **deps:** bump laravel/framework from 9.33.0 to 9.34.0 ([fad9840](https://github.com/rotex1800/registration/commit/fad9840125711489811caf93a19a42c36baabf51))
* **deps:** bump laravel/framework from 9.33.0 to 9.34.0 ([#25](https://github.com/rotex1800/registration/issues/25)) ([7bf45a2](https://github.com/rotex1800/registration/commit/7bf45a247d11c4855eb6c4574d3fb7eb7a5f854c))
* **deps:** bump laravel/sail from 1.16.1 to 1.16.2 ([62cd444](https://github.com/rotex1800/registration/commit/62cd44493a00bb28ee28df1f11ccde74f1ea32c1))
* **deps:** bump laravel/sail from 1.16.1 to 1.16.2 ([#24](https://github.com/rotex1800/registration/issues/24)) ([f15729a](https://github.com/rotex1800/registration/commit/f15729a1c4c3517d944d19a4b67bc9d6f61353ec))
* **deps:** bump nunomaduro/larastan from 2.2.0 to 2.2.1 ([38efaa3](https://github.com/rotex1800/registration/commit/38efaa33837aa28aaf4e3c8d375ab803356a960a))
* **deps:** bump nunomaduro/larastan from 2.2.0 to 2.2.1 ([#33](https://github.com/rotex1800/registration/issues/33)) ([bf0285b](https://github.com/rotex1800/registration/commit/bf0285b41cd864e277dbce06c4f7370ce1570426))
* **deps:** bump spatie/laravel-ignition from 1.5.0 to 1.5.1 ([6d15626](https://github.com/rotex1800/registration/commit/6d1562613385faaf77f518f07515a2e4683e7309))
* **deps:** bump spatie/laravel-ignition from 1.5.0 to 1.5.1 ([#26](https://github.com/rotex1800/registration/issues/26)) ([276b432](https://github.com/rotex1800/registration/commit/276b432d7f7a0fc92150331c203fa70726779168))
* **deps:** bump vite from 3.1.4 to 3.1.6 ([c88a498](https://github.com/rotex1800/registration/commit/c88a4984105c23a9f8d152c666dd6874d1974e6b))
* **deps:** bump vite from 3.1.4 to 3.1.6 ([#34](https://github.com/rotex1800/registration/issues/34)) ([dd7b2d0](https://github.com/rotex1800/registration/commit/dd7b2d0281ed376de685a675a0ec280b24edb710))
* Set default reviewers for dependabot PRs ([#31](https://github.com/rotex1800/registration/issues/31)) ([b0b07b9](https://github.com/rotex1800/registration/commit/b0b07b92f8341a80d01219b7abf4649a8b938258))

## [0.3.0](https://github.com/rotex1800/registration/compare/v0.2.0...v0.3.0) (2022-10-05)


### Features

* Add remaining upload ([#22](https://github.com/rotex1800/registration/issues/22)) ([0558e57](https://github.com/rotex1800/registration/commit/0558e57957fc2cd2cf70c061e34e5989371029b6))

## [0.2.0](https://github.com/rotex1800/registration/compare/v0.1.3...v0.2.0) (2022-10-03)


### Features

* Disassociate Documents and Info Models ([#19](https://github.com/rotex1800/registration/issues/19)) ([3cefbe9](https://github.com/rotex1800/registration/commit/3cefbe98cf6b6ee095357abedcf6b3bfdc310cf3))


### Miscellaneous Chores

* **check:** remove explicit name ([1417403](https://github.com/rotex1800/registration/commit/1417403d861ff542717f43d9f61116acf30ba4bd))

## [0.1.3](https://github.com/rotex1800/registration/compare/v0.1.2...v0.1.3) (2022-10-03)


### Miscellaneous Chores

* **check:** Add actionlint ([b570927](https://github.com/rotex1800/registration/commit/b570927586ffc06e45c1775ff59c007c7671f9e7))
* **check:** Add actionlint ([#16](https://github.com/rotex1800/registration/issues/16)) ([33c9adb](https://github.com/rotex1800/registration/commit/33c9adbc92c15e957060b07d6d6d329e6c2d2f6b))
* **check:** move gitleaks scan to check workflow ([5acf9a4](https://github.com/rotex1800/registration/commit/5acf9a438b2f6a3fbc3b6443e7c2bf5b4f602eee))
* **check:** move gitleaks scan to check workflow ([#18](https://github.com/rotex1800/registration/issues/18)) ([6fd2e94](https://github.com/rotex1800/registration/commit/6fd2e94d5ea0ea4b8d3ea36f0ff86bf200544aee))
* **deploy:** Display url ([02176a7](https://github.com/rotex1800/registration/commit/02176a7c0ee76b35fcb87bdfe8393d6a4b2e2091))

## [0.1.2](https://github.com/rotex1800/registration/compare/v0.1.1...v0.1.2) (2022-10-03)


### Bug Fixes

* **deploy:** Source user_bashrc before running script ([#15](https://github.com/rotex1800/registration/issues/15)) ([ab87cb5](https://github.com/rotex1800/registration/commit/ab87cb5a52821b5eecacc37da7898466f4687082))
