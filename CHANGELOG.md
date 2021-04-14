# Changelog

All notable changes to `tracking` will be documented in this file


## 0.1.0 - 2021-04-13
- update dependencies & fix imports
- optimize Travis CI config & enable code coverage uploading
- make TrackingServiceProvider that publishes migrations & configs as well as registering event listeners
- make database factories & migrations for `TrackAction`, `TrackActivity` & `TrackTraffic` models
- start making Feature & Unit test suites


## 0.1.1 - 2021-04-13
- fix use of `activeUserID()` helper function in `TrackActivityEvent`
- add sfneal/mock-models to dev requirements
- fix migration paths in `TrackingServiceProvider`


## 0.2.0 - 2021-04-14
- add use of `env()` helper function in config file
- fix use of sfneal/string-helpers helper functions by adding import of `StringHelpers`
- fix issue with `TrackTrafficObserver` not being attached to `TrackTraffic` model
- fix issue with `TrackTraffic` model not passing value to attribute setter in `TrackTrafficObserver`


## 0.2.1 - 2021-04-14
- cut relationships brought in from hpa app in `TrackingQuery`
- fix $parameters param to default as null in `TrackingQuery`
- start making query test suite
