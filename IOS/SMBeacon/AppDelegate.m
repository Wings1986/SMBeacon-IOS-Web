//
//  AppDelegate.m
//  SMBeacon
//
//  Created by iGold on 3/4/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import "AppDelegate.h"
#import "URBAlertView.h"
#import "Global.h"

#import <AFNetworking.h>

#import "ROXIMITYSDK.h"

#define ROXIMITY_APP_ID @"8d940ef6066e47d7945669586d4a9a16"
//#define ROXIMITY_APP_ID @"ec1e2994adeb4f79a680a90f1609bbf5"


@interface AppDelegate ()<ROXIMITYEngineDelegate, ROXBeaconRangeUpdateDelegate>

@end

@implementation AppDelegate


- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions {
    // Override point for customization after application launch.
    
    [[UINavigationBar appearance] setBarTintColor:[UIColor colorWithRed:227.0f/255.0f green:92.0f/255.0f blue:73.0f/255.0f alpha:1.0f]];
    [[UINavigationBar appearance] setTintColor:[UIColor whiteColor]];
    [[UINavigationBar appearance] setTitleTextAttributes:[NSDictionary dictionaryWithObjectsAndKeys:
                                                          [UIColor whiteColor], NSForegroundColorAttributeName,
                                                          nil]];

//    // set Local Notification
//    if ([UIApplication instancesRespondToSelector:@selector(registerUserNotificationSettings:)]){
//        [application registerUserNotificationSettings:[UIUserNotificationSettings settingsForTypes:UIUserNotificationTypeAlert|UIUserNotificationTypeBadge|UIUserNotificationTypeSound categories:nil]];
//    }
    
//    NSDictionary * roximityEngineOptions = @{
//                                             kROXEngineOptionsUserTargetingLimited : @NO,
//                                             kROXEngineOptionsMuteBluetoothOffAlert: @YES,
//                                             kROXEngineOptionsMuteLocationPermissionAlert : @NO,
//                                             kROXEngineOptionsMuteNotificationPermissionAlert: @NO,
//                                             kROXEngineOptionsMuteRequestAlerts: @YES,
//                                             kROXEngineOptionsReservedRegions: [NSNumber numberWithInt:5],
//                                             kROXEngineOptionsStartLocationDeactivated: @NO
//                                             };
    
    [ROXIMITYEngine startWithLaunchOptions:launchOptions engineOptions:nil andApplicationId:ROXIMITY_APP_ID];
    

    //Establish this viewcontroller as the delegate for beacon range update callbacks
    [ROXIMITYEngine setBeaconRangeDelegate:self withUpdateInterval:kROXBeaconRangeUpdatesFastest];
    
    //Establish this viewcontroller as the delegate or ROXIMITY engine callbacks
    [ROXIMITYEngine setROXIMITYEngineDelegate:self];
    
    //Example of setting a user alias in ROXIMITY SDK
    [ROXIMITYEngine setAlias:@"ROXStarterKit user"];

    self.appStatus = APP_NONE;
    
    return YES;
}

- (void)applicationDidEnterBackground:(UIApplication *)application {
    // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later.
    // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
    
    [ROXIMITYEngine background];   // Place in applicationDidEnterBackground
    
    self.appStatus = APP_NONE;
}

//- (void)applicationWillEnterForeground:(UIApplication *)application {
//    // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
//    
//    [ROXIMITYEngine foreground];   // Place in applicationWillEnterForeground
//    
//}

/*
- (void)applicationWillResignActive:(UIApplication *)application {
    // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
    // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.

    [ROXIMITYEngine resignActive]; // Place in applicationWillResignActive

}

- (void)applicationDidBecomeActive:(UIApplication *)application {
    // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
    
    [ROXIMITYEngine active];       // Place in applicationDidBecomeActive
    
}

- (void)applicationWillTerminate:(UIApplication *)application {
    // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
    
    [ROXIMITYEngine terminate];    // Place in applicationWillTerminate
}


//Adding the following methods for remote notification handling
-(void) application:(UIApplication *)application didFailToRegisterForRemoteNotificationsWithError:(NSError*)error
{
    [ROXIMITYEngine didFailToRegisterForRemoteNotifications:error];
}

-(void)application:(UIApplication *)application didRegisterForRemoteNotificationsWithDeviceToken:(NSData *)deviceToken
{
    [ROXIMITYEngine didRegisterForRemoteNotifications:deviceToken];
}

-(void)application:(UIApplication *)application didReceiveRemoteNotification:(NSDictionary *)userInfo fetchCompletionHandler:(void (^)(UIBackgroundFetchResult))completionHandler{
    [ROXIMITYEngine didReceiveRemoteNotification:application userInfo:userInfo fetchCompletionHandler:completionHandler];
}

-(void)application:(UIApplication *)application didReceiveRemoteNotification:(NSDictionary *)userInfo{
    [ROXIMITYEngine didReceiveRemoteNotification:application userInfo:userInfo];
}

-(void)application:(UIApplication *)application didReceiveLocalNotification:(UILocalNotification *)notification{
    [ROXIMITYEngine didReceiveLocalNotification:application notification:(UILocalNotification *)notification];
}
*/

#pragma mark Notification
-(void)application:(UIApplication *)application didReceiveLocalNotification:(UILocalNotification *)notification {

    if (self.appStatus == APP_BUSY) {
        return;
    }

    self.appStatus = APP_BUSY;
    
    NSString* msg = @"There is an offer available from ";
    NSString* merchant = notification.userInfo[@"merchant"][@"merchantName"];

//    UIFont *systemFont = [UIFont systemFontOfSize:14.0];
//    UIFont *boldFont = [UIFont boldSystemFontOfSize:15.0];
    
//    NSDictionary *arialdict = [NSDictionary dictionaryWithObject: systemFont forKey:NSFontAttributeName];
//    NSMutableAttributedString *AattrString = [[NSMutableAttributedString alloc] initWithString:msg attributes: arialdict];
//    [AattrString addAttribute:NSForegroundColorAttributeName value:[UIColor whiteColor] range:(NSMakeRange(0, msg.length))];
//    
//    NSDictionary *veradnadict = [NSDictionary dictionaryWithObject:boldFont forKey:NSFontAttributeName];
//    NSMutableAttributedString *VattrString = [[NSMutableAttributedString alloc] initWithString: merchant attributes:veradnadict];
//    [VattrString addAttribute:NSForegroundColorAttributeName value:[UIColor whiteColor] range:(NSMakeRange(0, merchant.length))];
//
//    [AattrString appendAttributedString:VattrString];
//    
//    NSString* message = AattrString.string;
    NSString* message = [NSString stringWithFormat:@"%@%@", msg, merchant];
    
    URBAlertView *alertView = [[URBAlertView alloc] initWithTitle:@"PUSH NOTIFICATION"
                                                          message:message
                                                cancelButtonTitle:@"CLOSE"
                                                otherButtonTitles:@"SHOW", nil];
    [alertView setHandlerBlock:^(NSInteger buttonIndex, URBAlertView *alertView) {
        [alertView hideWithCompletionBlock:^{
            
            self.appStatus = APP_NONE;
            
            if (buttonIndex == 1) { // OK
                dispatch_async(dispatch_get_main_queue(),^{
                    [[NSNotificationCenter defaultCenter] postNotificationName:@"notification_open_offer" object:notification.userInfo];
                });
            }
            else { // no
//                self.arrayBeacons = nil;
            }
            
        }];
    }];
    [alertView showWithAnimation:URBAlertAnimationFlipHorizontal];
}

- (void)setNotification:(NSDictionary*) offerData {
    
    NSString* msg = @"There is an offer available from ";
    NSString* merchant = offerData[@"merchant"][@"merchantName"];
    
    NSString* message = [NSString stringWithFormat:@"%@%@", msg, merchant];

    UILocalNotification *localNotification = [[UILocalNotification alloc] init];
    localNotification.fireDate = [NSDate date];
    localNotification.alertBody = message;
    localNotification.soundName = UILocalNotificationDefaultSoundName;
//    localNotification.applicationIconBadgeNumber = 1;
    localNotification.userInfo = [[NSDictionary alloc] initWithDictionary:offerData];
    
    [[UIApplication sharedApplication] scheduleLocalNotification:localNotification];
}

//-(void) userLoggedIn:(User *)user{
//    
//    NSLog(@"The user has successfully logged in, setting email as ROXIMITY alias");
//    
//    [ROXIMITYEngine setAlias:user.email];
//}
//
//-(void) userLoggedOut{
//    
//    NSLog(@"The user has logged out, removing ROXIMITY alias");
//    
//    [ROXIMITYEngine removeAlias];
//}

#pragma mark - Beacon Delegate
//ROXIMITY Beacon Delegate Methods
- (void) didUpdateBeaconRanges:(NSArray *)rangedBeacons{
//    if ([rangedBeacons count] == 0){
//        return;
//    }
    
    NSLog(@"ROXIMITY found the following beacons: \n%@", rangedBeacons);
    
/*
    kROXNotifBeaconId - An alpha-numeric NSString of the ROXIMITY assigned identifier of the beacon
    
    kROXNotifBeaconName - A NSString of the name you have assigned to that beacon through the ROXIMITY web interface
    
    kROXNotifBeaconTags - A NSArray of tags you have assigned to that beacon through the ROXIMITY web interface
    
    kROXNotifBeaconProximityString - An NSString of the beacons proximity range, values can be “Unknown”, “Far”, “Near”, and“Immediate”
    
    kROXNotifBeaconProximityValue - A NSNumber of the proximity value, corresponds to the PROXIMITY_STRING value as such:
    
    0 = “Unknown”
    1 = “Immediate” 
    2 = “Near” 
    3 = “Far”
*/
    
//    if (self.arrayBeacons != nil) {
//        self.arrayBeacons = [[NSMutableArray alloc] init];
//    }
//
//    for (NSDictionary *newBeacon in rangedBeacons) {
//        
//        int indexObject = [self indexOfBeacons:newBeacon];
//        if (indexObject == -1) { // no exist
//            [self.arrayBeacons addObject:newBeacon];
//            
//            [self requestService:newBeacon];
//        }
//        else {
//            NSDictionary* oldBeacon = self.arrayBeacons[indexObject];
//            
//            if (![newBeacon[@"proximity_value"] isEqualToNumber:oldBeacon[@"proximity_value"]]) {
//                [self.arrayBeacons replaceObjectAtIndex:indexObject withObject:newBeacon];
//            }
//        }
//        
//        
//        int index = 0;
//        for (NSDictionary *oldBeacon in self.arrayBeacons) {
//            
//            if ([newBeacon[@"beacon_id"] isEqualToString:oldBeacon[@"beacon_id"]]
//                && ![newBeacon[@"proximity_value"] isEqualToNumber:oldBeacon[@"proximity_value"]]) {
//                
//                [self.arrayBeacons replaceObjectAtIndex:index withObject:newBeacon];
//                
//                break;
//            }
//            
//            index ++;
//        }
//    }
    

    NSDictionary* detectedBeacon = [rangedBeacons firstObject];
    
    if (detectedBeacon != nil && ![self isCheckedBeacon:detectedBeacon]) {
        [self requestService:detectedBeacon];
    }
    
    
    self.arrayBeacons = [[NSMutableArray alloc] initWithArray:rangedBeacons];
    
    // change saved offer's beacon infos
    [self changeOfferStatus];
    
    
}
- (BOOL) isCheckedBeacon:(NSDictionary*) beacon
{
    if ([beacon[@"proximity_value"] intValue] <= 0) {
        return YES;
    }
    if (self.arrayBeacons == nil) {
        return NO;
    }
    
    for (NSDictionary* oldBeacon in self.arrayBeacons) {
        if ([beacon[@"beacon_name"] isEqualToString:oldBeacon[@"beacon_name"]]
            /*&& [beacon[@"proximity_value"] isEqualToNumber:oldBeacon[@"proximity_value"]]*/) {
            return YES;
        }
    }
    
    return NO;
}
- (int) indexOfBeacons:(NSDictionary*) beacon
{
    if (self.arrayBeacons.count == 0) {
        return -1;
    }
    
    for (int i = 0; i < self.arrayBeacons.count; i ++) {
        NSDictionary* oldBeacon = self.arrayBeacons[i];
        
        if ([beacon[@"beacon_name"] isEqualToString:oldBeacon[@"beacon_name"]]) {
            return i;
        }
    }
    
    return -1;
}
- (void) changeOfferStatus
{
    
    NSArray* allOfferList = [Global loadOfferList];
    if (allOfferList != nil) {
        
        NSMutableArray * arrayOffer = [[NSMutableArray alloc] initWithArray:allOfferList];
        
        BOOL bChanged = NO;
        for (int index = 0; index < arrayOffer.count; index ++) {
            NSMutableDictionary * oneOfferDetail = [[NSMutableDictionary alloc] initWithDictionary:arrayOffer[index]];
            
            NSDictionary* oldBeacon = oneOfferDetail[@"beacon"];
            
            for (NSDictionary *newBeacon in self.arrayBeacons) {
                if ([oldBeacon[@"beacon_name"] isEqualToString:newBeacon[@"beacon_name"]]
                    && ![oldBeacon[@"proximity_value"] isEqualToNumber:newBeacon[@"proximity_value"]]) {
                    

                        oneOfferDetail[@"beacon"] = newBeacon;
//                    [oneOfferDetail setObject:newBeacon forKey:@"beacon"];
                    
                        [arrayOffer replaceObjectAtIndex:index withObject:oneOfferDetail];
                    
                    bChanged = YES;
                    
                    break;
                }
            }
        }
        
        if (bChanged) {
            [Global saveOfferList:arrayOffer];
        }
        
    }

    
}

//ROXIMITY Engine Delegate methods
-(void) bluetoothStateChange:(BOOL)bluetoothOn{
    NSLog(@"Bluetooth capabilities are %@", bluetoothOn ? @"ON" : @"OFF");
}

-(void) aliasSetResult:(BOOL)success alias:(NSString *)alias error:(NSError *)error{
    if (success){
        NSLog(@"Alias has been set to: %@", [ROXIMITYEngine getAlias]);
    }else{
        NSLog(@"There was an error setting the alias: %@", error);
    }
}

-(void) aliasRemoveResult:(BOOL)success error:(NSError *)error{
    
    if (success){
        NSLog(@"Alias has been removed");
    }else{
        NSLog(@"There was an error removing the alias: %@", error);
    }
}

#pragma mark - SERVER communication
- (void) requestService:(NSDictionary*) beacon
{
    if (beacon != nil) {
        [self getOfferDetail:beacon];
    }
    
}
- (void) getOfferDetail:(NSDictionary*) beacon
{
    
    
    NSString *requestURL = [[NSString stringWithFormat:@"%@=getoffer&beacon=%@",
                            SERVER_URL,
                             beacon[@"beacon_name"]] stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
    
    NSLog(@"request = %@", requestURL);

    
    NSURLSessionConfiguration *sessionConfiguration = [NSURLSessionConfiguration defaultSessionConfiguration];
    
    AFHTTPSessionManager *manager = [[AFHTTPSessionManager alloc] initWithSessionConfiguration:sessionConfiguration];
    manager.responseSerializer = [AFJSONResponseSerializer serializer];
    
    [manager GET:requestURL parameters:nil success:^(NSURLSessionDataTask *task, id responseObject) {

        NSMutableDictionary *offerDetails = [[NSMutableDictionary alloc] initWithDictionary:responseObject];
        
        NSLog(@"offerDetails = %@", offerDetails);
        
        if (offerDetails != nil) {
            [self makeOfferDetail:offerDetails BEACON:(NSDictionary*) beacon];
        }

        
    } failure:^(NSURLSessionDataTask *task, NSError *error) {
        NSLog(@"error = %@", error.description);
    }];
    
//    AFHTTPRequestOperationManager *manager = [AFHTTPRequestOperationManager manager];
//    manager.responseSerializer = [AFJSONResponseSerializer serializer];
//
//    [manager GET:requestURL
//       parameters:nil
//          success:^(AFHTTPRequestOperation *operation, id responseObject) {
//              
//              NSDictionary *result = (NSDictionary*) responseObject;
//              
//              NSLog(@"response = %@", result);
//              
//              NSMutableDictionary *offerDetails = [[NSMutableDictionary alloc] initWithDictionary:responseObject];
//              
//              NSLog(@"offerDetails = %@", offerDetails);
//              
//              [self makeOfferDetail:offerDetails BeaconProximityString:proxStr BeaconProximityValue:proxValue];
//
//          }
//          failure:^(AFHTTPRequestOperation *operation, NSError *error) {
//              NSLog(@"error = %@", error.description);
//          }];
}

- (void) makeOfferDetail:(NSMutableDictionary*) details BEACON:(NSDictionary*) beacon
{
/*
 kOfferID
 kOfferTitle
 kOfferDescription
 kOfferPic
 ...
 kOfferStatus
 
 */
 
    NSMutableDictionary * offer = [[NSMutableDictionary alloc] initWithDictionary:details[@"offer"]];
    
    [offer setObject:[NSNumber numberWithInt:OFFER_NONE] forKey:@"offerStatus"];

    NSArray* allOfferList = [Global loadOfferList];
    if (allOfferList != nil) {
        for (NSDictionary * oneOfferDetail in allOfferList) {
            if ([offer[@"offerID"] isEqualToString:oneOfferDetail[@"offer"][@"offerID"]]) {
                [offer setObject:oneOfferDetail[@"offer"][@"offerStatus"] forKey:@"offerStatus"];
                [offer setObject:oneOfferDetail[@"offer"][@"offer_start_time"] forKey:@"offer_start_time"];
                break;
            }
            
        }
    }
    
    // change offer value
    [details setObject:offer forKey:@"offer"];

    // add beacon info
    [details setObject:beacon forKey:@"beacon"];
    
    
//    NSMutableDictionary * merchant = [[NSMutableDictionary alloc] initWithDictionary:details[@"merchant"]];
//    [merchant setObject:@"state" forKey:@"merchantState"];
//    [merchant setObject:@"zip" forKey:@"merchantZip"];
//    
//    // change merchant value
//    [details setObject:merchant forKey:@"merchant"];
    
    NSLog(@"notification = %@", details);
    
    [self setNotification:details];
    
}


@end
