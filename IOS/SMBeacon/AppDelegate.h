//
//  AppDelegate.h
//  SMBeacon
//
//  Created by iGold on 3/4/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import <UIKit/UIKit.h>

#import "Global.h"

@interface AppDelegate : UIResponder <UIApplicationDelegate>

@property (strong, nonatomic) UIWindow *window;

@property (strong, nonatomic) NSMutableArray * arrayBeacons;
@property (assign, nonatomic) APP_STATUS    appStatus;

- (void) getOfferDetail:(NSString*) beaconID BEACON:(NSDictionary*) beacon;

@end

