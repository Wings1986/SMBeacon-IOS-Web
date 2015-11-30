//
//  Global.h
//  SMBeacon
//
//  Created by iGold on 3/4/15.
//  Copyright (c) 2015 Info Geniuz. All rights reserved.
//

#import <Foundation/Foundation.h>

typedef enum
{
    OFFER_NONE,
    OFFER_ACCEPTED,
//    OFFER_REDEEM,
    OFFER_REDEEMED,
}OFFERSTATUS;

typedef enum
{
    APP_NONE,
    APP_BUSY,
    
}APP_STATUS;

@interface Global : NSObject

//#define SERVER_URL      @"http://localhost/SMBeacon/api/index.php?action"
#define SERVER_URL      @"http://smbeacon.louisville911.com/api/index.php?action"


+ (void) saveOfferList:(NSMutableArray*) arry;
+ (NSMutableArray*) loadOfferList;

@end
