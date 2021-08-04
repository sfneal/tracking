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


## 0.3.0 - 2021-04-14
- cut support for php7.4
- cut relationships brought in from hpa app in `TrackActionQuery`
- fix $parameters param to default as null in `TrackingQuery`
- start making query test suite


## 0.3.1 - 2021-04-15
- cut relationships brought in from hpa app in `TrackActivityQuery`
- improve `TrackAction` & `TrackActivity` database factory definitions
- add queries feature test suite


## 0.3.2 - 2021-04-15
- fix issues with `TrackAction`, `TrackActivity` & `TrackTraffic` actions & jobs not returning newly created models
- fix issues with migrations not allowing columns to be nullable
- fix min sfneal/laravel-helpers version to ensure `AppInfo::env()` method is supported
- add unit tests to test suite


## 0.3.3 - 2021-04-15
- cut redundant actions & jobs that are only called from a single class


## 0.4.0 - 2021-04-15
- cut use of `session_id()` in `ParseTrafficAction`
- add use of config 'session.cookie' key for retrieving session id
- fix issue with 'session_id' column not being nullable
- add 'tracking.queue' & 'tracking.driver' keys to config file
- add use of 'tracking.queue' & 'tracking.driver' config keys in `TrackActionJob` & `TrackActivityListener`


## 0.5.0 - 2021-04-15
- refactor `ParseTrafficAction` to `ParseTraffic`
- fix issue with `ParseTraffic` response time results not being type cast to floats
- improve parameter & return type hinting
- add public `parse()` methods to `ParseTraffic` to enable use cases where not all data is needed to be retrieved


## 0.5.1 - 2021-04-15
- optimize `TrackTrafficMiddleware` by deferring adding a unique id token until after confirming tracking is enabled


## 0.5.2 - 2021-04-16
- fix issue with `Response` type hinting as `RedirectResponse` $response params are also acceptable


## 0.6.0 - 2021-04-16
- make `ModelAdapter` for dynamically retrieving model classes
- add 'models' section to 'tracking' config that allows for overwriting default models with custom extensions
- add use of `ModelAdapter` for accessing `TrackAction`, `TrackActivity` & `TrackTraffic` models
- cut `TrackingRelationship` trait and use in models


## 0.7.0 - 2021-04-19
- add testing of `TrackActivity` 'tracking' relationship
- add use of `HasRelationships` trait to abstract `TrackingQuery`
- refactor constructor params of `TrackActionQuery` & `TrackActivityQuery` to no longer include $relationships


## 0.7.1 - 2021-04-19
- bump sfneal/datum min version to v1.4


## 0.7.2 - 2021-04-20
- bump sfneal/mock-models dev requirement to v0.2
- refactor use of testing utility traits & interfaces to sfneal/mock-models imports


## 0.8.0 - 2021-04-20
- make `CleanDevTrackingCommand` & add publishing to `TrackingServiceProvider` with test methods
- add use of config queue & connection settings in `CleanDevTrackingJob`


## 0.8.1 - 2021-04-20
- optimize queries test suite


## 0.9.0 - 2021-04-21
- make `TrackRequest` for validating `TrackActivityQuery` & `TrackActionQuery` request params
- add use of `TrackRequest` validation in `TrackingQuery` constructor
- fix issue with $model_key not returning an integer in `query_with_table_and_key_params()` test methods


## 0.9.1 - 2021-04-21
- bump sfneal/mock-models min version to v0.3
- add use of `RequestCreator` interface in `QueriesTestCase`
- bump sfneal/datum min version to v1.5
- add import of `Sfneal\Requests\FormRequest` in `TrackRequest`


## 0.10.0 - 2021-04-22
- refactor `TrackAction` & `TrackActivity` to use polymorphic relationships
- refactor 'model_key' attributes to 'trackable_id'
- refactor 'model_table' attributes to 'trackable_type'
- refactor tracking factories to require `People` models to be created prior to using


## 0.10.1 - 2021-04-26
- refactor `TrackActionQuery` & `TrackActivity` params to use new attribute names
- refactor 'table' param to 'type'
- refactor 'key' param to 'id'


## 0.10.2 - 2021-05-04
- fix use of 'tracking.queue_driver' to 'tracking.driver'


## 1.0.0 - 2021-05-05
- initial production release
- bump sfneal/users min version v1.0


## 1.0.1 - 2021-05-06
- fix issue with `TrackTrafficMiddleware` creating the $response before adding the 'track_traffic_token' attribute to the $request


## 1.0.2 - 2021-05-06
- optimize `TrackTrafficMiddleware` by adding token's & creating responses once


## 1.0.3 - 2021-05-10
- bump sfneal/controllers min package version to v2.1
- add use of `Middleware` interface implementation in `TrackTrafficMiddleware` middleware


## 1.0.4 - 2021-08-03
- bump min sfneal/array-helpers version to v2.0 & refactor use
- add explicit sfneal/address composer requirement


## 1.0.5 - 2021-08-04
- bump min sfneal/array-helpers version to v3.0 & refactor use
