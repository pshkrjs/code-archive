/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pr_5;

import java.io.BufferedReader; 
import java.io.IOException; 
import java.nio.charset.StandardCharsets; 
import java.nio.file.Files; 
import java.nio.file.Path; 
import java.nio.file.Paths;
import java.util.ArrayList; 
import java.util.List;
/**
 *
 * @author pshkrjshnde
 */

/** * Simple Java program to read CSV file in Java. In this program we will read * list of books stored in CSV file as comma separated values.  */
public class CSVReader {
    
     public static List<Data> take(String file){
         List<Data> dataSet = readDataFromCSV(file);
        // let's print all the person read from CSV file
         
        return dataSet;
     }
    private static List<Data> readDataFromCSV(String fileName) { 
        List<Data> dataSet = new ArrayList<>(); 
        Path pathToFile = Paths.get(fileName); 
        // create an instance of BufferedReader // using try with resource, Java 7 feature to close resources 
        try (BufferedReader br = Files.newBufferedReader(pathToFile,
                StandardCharsets.US_ASCII)) { 
        // read the first line from the text file 
                String line = br.readLine(); 
        // loop until all lines are read 
                    while (line != null) { 
                        // use string.split to load a string array with the values from 
                        // each line of 
                        // the file, using a comma as the delimiter 
                        //System.out.println(line);
                        String[] attributes = line.split(","); 
                        Data data = createData(attributes); 
                        // adding book into ArrayList 
                        dataSet.add(data); 
                        // read next line before looping 
                        // if end of file reached, line would be null 
                        line = br.readLine();
                }
        }catch (IOException ioe) { 
        ioe.printStackTrace(); 
        } 
        return dataSet; 
    } 
    private static Data createData(String[] metadata) {
        String label = metadata[0]; 
        double f1 = Double.parseDouble(metadata[1]); 
        double f2 = Double.parseDouble(metadata[2]); 
        double f3 = Double.parseDouble(metadata[3]); 
        double f4 = Double.parseDouble(metadata[4]); 
        double f5 = Double.parseDouble(metadata[5]); 
        // create and return book of this metadata 
        return new Data(label, f1, f2, f3, f4, f5); 
    } 
} 



