use grocerylist;

CALL load_taxrates();

INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Milk', 4.29, 3.49, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Eggs', 2.35, 0.00, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Coffee', 5.49, 0.00, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Cream', 2.50, 0.00, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Sugar', 3.00, 0.00, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Fish Sticks', 9.00, 7.35, 1, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Relish', 2.49, 0.00, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Tuna', 0.88, 0.00, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Potatoes', 4.00, 0.00, 0, 0, 0, 0);

INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Carrots', 2.49, 0.00, 0, 0, 0, 0);
    
INSERT INTO Items (item_name, price, sale_price, use_sale_price, GST, PST, HST) 
	VALUES ('Steak', 10.00, 0.00, 0, 0, 0, 0);

INSERT INTO Lists (list_name, budget) 
    VALUES ('Sunday Shopping', 70.35);
    
INSERT INTO Lists (list_name, budget) 
    VALUES ('Tuesday Shopping', 20.35);
    
INSERT INTO Lists (list_name, budget) 
    VALUES ('Jons Birthday', 99999.35);

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (12,1 ,1,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (7,2 ,2,1 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (5,3 ,3,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (2,4 ,1,1 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (1,5 ,2,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (2,6 ,3,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (8,7 ,1,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (9,8 ,2,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (10,9 ,3,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (6,10 ,1,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (90,11 ,2,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (7,11 ,3,0 );

INSERT INTO listitems (quantity, itemID, listID, checked)
	VALUES (16,1 ,1,0 );
    