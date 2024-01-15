import java.awt.Color;
import java.awt.Font;
import java.io.*;
import java.util.*;

import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartFrame;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.CategoryPlot;
import org.jfree.chart.plot.PiePlot;
import org.jfree.data.general.DefaultPieDataset;
import org.jfree.ui.ApplicationFrame;
import org.jfree.ui.RefineryUtilities;

import java.text.*;

import com.datastax.driver.core.Cluster;
import com.datastax.driver.core.ResultSet;
import com.datastax.driver.core.Row;
import com.datastax.driver.core.Session;

import com.restfb.Connection;
import com.restfb.DefaultFacebookClient;
import com.restfb.FacebookClient;
import com.restfb.types.Page;

import weka.core.*;
import weka.core.Instance;
import weka.core.Instances;
import weka.core.Attribute;

import weka.classifiers.*;
import weka.classifiers.Classifier;
import weka.classifiers.trees.*;
import weka.classifiers.trees.j48.*;
import weka.classifiers.bayes.*;
import weka.filters.unsupervised.attribute.StringToWordVector;

public class FbLikeClassifier {

	private String[] inputText = null;
	private String[] inputClasses = null;
	private String classString = null;

	private Attribute classAttribute = null;
	private Attribute textAttribute = null;
	private FastVector attributeInfo = null;
	private Instances instances = null;
	private Classifier classifier = null;
	private Instances filteredData = null;
	private Evaluation evaluation = null;
	private Set modelWords = null;

	static Cluster cluster;
	static Session session;
	static ResultSet results;
	static Row rows;

	// maybe this should be settable?
	private String delimitersStringToWordVector = "\\s.,:'\\\"()?!";

	//
	// main, mainly for testing
	//
	public static void main(String args[]) {

		String accessToken = "EAACEdEose0cBAGOOyc8eXGTQQD6hE9ePZC7DmTUZCUqXbDaZCV5QApaZC29bXNLUbsW3szCmLaxZAOImFkuLiwWZAaWUzikAe561bBHVLW1Uc6ATdHBjecUvMTC6h31jdAcTV9cZBnfyzjyFUIBJbqKD266WT0YyJlZCi22jUmgXeQRQ3gWtNanfkWQPx6yx9D0ZD";

		@SuppressWarnings("deprecation")
		FacebookClient fbClient = new DefaultFacebookClient(accessToken); // Setting
																			// version
																			// has
																			// no
																			// effect

		Connection<Page> result = fbClient.fetchConnection("me/likes", Page.class);
		int counter = 0;
		String[] testText = new String[40];
		String[] strfblikes = new String[40];
		String lstr = "";
		try {
			cluster = Cluster.builder().addContactPoint("127.0.0.1").build();
			session = cluster.connect();
			session.execute("CREATE KEYSPACE IF NOT EXISTS facebooklikes WITH replication "
					+ "= {'class':'SimpleStrategy','replication_factor':1}; ");
			session.execute("USE facebooklikes");
			// create users table
			session.execute("CREATE TABLE IF NOT EXISTS fblikes2 (like text PRIMARY KEY);");
			// Insert records into the users table

			for (List<Page> feedPage : result) {

				lstr = "";
				for (Page Page : feedPage) {
					if (counter < 40) {
						System.out.println(counter + " : " + Page.getName());
						strfblikes[counter] = Page.getName();
						counter++;
					}
				}
			}

			for (int i = 0; i < 40; i++) {

				lstr = "";
				lstr = strfblikes[i].replace('\'', '_');
				session.execute("INSERT INTO fblikes2 (like) VALUES ('" + lstr + "')");
				testText[i] = "Computer";
			}

			results = session.execute("SELECT * FROM fblikes2");
			int lcnt = 0;

			for (Row row : results) {
				if (lcnt < 40) {
					lstr = "";
					testText[lcnt] = row.getString("like");
					lcnt++;
				}
			}

		} catch (Exception e) {
			System.out.println("Error 1: " + e.getMessage());
		}

		System.out.println("Number of results :" + counter);

		cluster.close();

		// String classString = "weka.classifiers.bayes.NaiveBayes";
		String thisClassString = "weka.classifiers.lazy.IBk";

		if (args.length > 0) {
			thisClassString = args[0];
		}

		String[] inputText = { "Dhoni is my favourite #", "Coollest caption ever india have - Ms Dhoni",
				"Rocky Handsome is JOhn next movie", "Next movie of Yami Gautam is Action Jaction",
				"Taylor Swift won 3 Oscar awards this year", "Arjun Kapoor is hot actor !", "Comedy Nights with Kapil",
				"Hrithik Roshan is hero", "Deepika Padukone is heroine", "Bollywood", "Kesha is singer",
				"Parineeti is hot Actress !", "Priya Bapat is marathi actress", "Morgan Freeman hollywood actor",
				"Bipasha Basu was John Abraham  Girlfriend !", "Daniel Craig is retiring from Bond series",
				"DiCaprio worked in Titanic", "Taapsee Pannu is South Indian", "Siddharth Jadhav is marathi hero",
				"Emma Watson acted in Harry Potter Movie", "Pitbullis is rapper", "Shreya Ghoshal is singer",
				"Vin Diesel - Fast & Furious", "Yo Yo KG Singh", "Enrique Iglesias and A.R. Rahman are Singer",
				"Priyanka Chopra is Former Miss India", "Selena Gomez", "Mr. Bean is Comedy", "Linkin Park", "Usher",
				"Shakira- Hips Dont lie", "Eminem", "Sunidhi Chauhan", "Huma Qureshi is an actress",
				"Iron Man - Robert Downey Jr", "Vidyut Jammwal", "Information that's all you need !",
				"Software industry", "Android", "Information Technology", "Computer", "Hacking is cool",
				"Technology never goes out of scope", "Facebook Engineering", "PrimeTech Computer Institute", "Facts",
				"Google", "Hacker", "Interships", "Engineering Jobs in industries", "IIT Kharagpur",
				"Impetus & Concepts is Technical event of PICT College", "Microsoft", "Tech and Facts",
				"Computer programmers", "Inventions", "Ruby is programming languange", "IT",
				"Technologies have made life easy !", "Psychology is hard subject", " Electronics Design", "C", "C++",
				"Java", "Python", "Intel", "Computer Technology", "Samsung Mobile", "Architecture" };

		String[] inputClasses = { "Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment",
				"Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment",
				"Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment",
				"Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment",
				"Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment",
				"Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment", "Entertainment",
				"Entertainment", "Technical", "Technical", "Technical", "Technical", "Technical", "Technical",
				"Technical", "Technical", "Technical", "Technical", "Technical", "Technical", "Technical", "Technical",
				"Technical", "Technical", "Technical", "Technical", "Technical", "Technical", "Technical", "Technical",
				"Technical", "Technical", "Technical", "Technical", "Technical", "Technical", "Technical", "Technical",
				"Technical", "Technical", "Technical" };
		try {
			results = session.execute("SELECT * FROM fblikes2");
			int lcnt = 0;

			for (Row row : results) {
				if (lcnt < 40) {
					lstr = "";
					testText[lcnt] = row.getString("like");
					System.out.println(lcnt + " :" + testText[lcnt]);
					lcnt++;
				}
			}

		} catch (Exception e) {
			System.out.println("Error 1: " + e.getMessage());
		}

		if (inputText.length != inputClasses.length) {
			System.err.println("The length of text and classes must be the same!");
			System.exit(1);
		}

		// calculate the classValues
		HashSet classSet = new HashSet(Arrays.asList(inputClasses));
		classSet.add("?");
		String[] classValues = (String[]) classSet.toArray(new String[0]);

		//
		// create class attribute
		//
		FastVector classAttributeVector = new FastVector();
		for (int i = 0; i < classValues.length; i++) {
			classAttributeVector.addElement(classValues[i]);
		}
		Attribute thisClassAttribute = new Attribute("class", classAttributeVector);

		//
		// create text attribute
		//
		FastVector inputTextVector = null; // null -> String type
		Attribute thisTextAttribute = new Attribute("text", inputTextVector);
		for (int i = 0; i < inputText.length; i++) {
			thisTextAttribute.addStringValue(inputText[i]);
		}

		// add the text of test cases
		for (int i = 0; i < testText.length; i++) {
			thisTextAttribute.addStringValue(testText[i]);
		}

		//
		// create the attribute information
		//
		FastVector thisAttributeInfo = new FastVector(2);
		thisAttributeInfo.addElement(thisTextAttribute);
		thisAttributeInfo.addElement(thisClassAttribute);

		FbLikeClassifier classifier = new FbLikeClassifier(inputText, inputClasses, thisAttributeInfo,
				thisTextAttribute, thisClassAttribute, thisClassString);

		System.out.println("DATA SET:\n");
		System.out.println(classifier.classify(thisClassString));

		System.out.println("NEW CASES:\n");
		classified(inputText, inputClasses, testText);
		// System.out.println(classifier.classifyNewCases(testText));

	} // end main

	private static void classified(String[] inputText2, String[] inputClasses2, String[] testText3) {
		String[] words = new String[100];
		String[] arr = new String[100];
		// int count1=0,count2=0,count3=0;
		int k = 0, found_at, found;
		for (int i = 0; i < testText3.length; i++) {
			found_at = -1;
			found = -1;

			for (int j = 0; j < inputText2.length; j++) {
				arr = testText3[i].split(" ");
				k = 0;
				for (String ss : arr) {
					words[k] = ss;
					found = inputText2[j].indexOf(words[k]);
					if (found > -1)
						break;
					k++;
				}
				if (found > (-1)) {
					found_at = j;
					System.out.println(" Testing : " + testText3[i]);
					System.out.println(" Classified as : " + inputClasses2[j] + "\n");
					if (inputClasses2[j] == "Technical")
						var.count1++;
					else if (inputClasses2[j] == "Entertainment")
						var.count2++;
					break;
				}
			}
			if (found_at == -1) {
				var.count3++;
				System.out.println(" Testing : " + testText3[i]);
				System.out.println(" Classified as : " + "Other" + "\n");
			}

		}

		System.out.println(var.count1);
		System.out.println(var.count2);

		System.out.println(var.count3);

		PieChartDemo demo = new PieChartDemo("Facebook user like classification");
		demo.pack();
		RefineryUtilities.centerFrameOnScreen(demo);
		demo.setVisible(true);

	}

	//
	// constructor
	//
	FbLikeClassifier(String[] inputText, String[] inputClasses, FastVector attributeInfo, Attribute textAttribute,
			Attribute classAttribute, String classString) {
		this.inputText = inputText;
		this.inputClasses = inputClasses;
		this.classString = classString;
		this.attributeInfo = attributeInfo;
		this.textAttribute = textAttribute;
		this.classAttribute = classAttribute;
	}

	//
	// make classification and everything
	//
	public StringBuffer classify() {

		if (classString == null || "".equals(classString)) {
			return (new StringBuffer());
		}

		return classify(classString);

	} // end classify()

	//
	// the real classify method
	//
	public StringBuffer classify(String classString) {

		this.classString = classString;

		StringBuffer result = new StringBuffer();

		// creates an empty instances set
		instances = new Instances("data set", attributeInfo, 100);

		// set which attribute is the class attribute
		instances.setClass(classAttribute);

		try {

			instances = populateInstances(inputText, inputClasses, instances, classAttribute, textAttribute);
			result.append("DATA SET:\n" + instances + "\n");

			// make filtered SparseData
			filteredData = filterText(instances);

			// create Set of modelWords
			modelWords = new HashSet();
			Enumeration enumx = filteredData.enumerateAttributes();
			while (enumx.hasMoreElements()) {
				Attribute att = (Attribute) enumx.nextElement();
				String attName = att.name().toLowerCase();
				modelWords.add(attName);

			}

			//
			// Classify and evaluate data
			//
			classifier = Classifier.forName(classString, null);

			classifier.buildClassifier(filteredData);
			evaluation = new Evaluation(filteredData);
			evaluation.evaluateModel(classifier, filteredData);

			result.append(printClassifierAndEvaluation(classifier, evaluation) + "\n");

			// check instances
			int startIx = 0;
			result.append(checkCases(filteredData, classifier, classAttribute, inputText, "not test", startIx) + "\n");

		} catch (Exception e) {
			e.printStackTrace();
			result.append("\nException (sorry!):\n" + e.toString());
		}

		return result;

	} // end classify

	//
	// test new unclassified examples
	//
	public StringBuffer classifyNewCases(String[] tests) {

		StringBuffer result = new StringBuffer();

		//
		// first copy the old instances,
		// then add the test words
		//

		Instances testCases = new Instances(instances);
		testCases.setClass(classAttribute);

		String[] testsWithModelWords = new String[tests.length];
		int gotModelWords = 0; // how many words will we use?

		for (int i = 0; i < tests.length; i++) {
			// the test string to use
			StringBuffer acceptedWordsThisLine = new StringBuffer();

			// split each line in the test array
			String[] splittedText = tests[i].split("[" + delimitersStringToWordVector + "]");
			// check if word is a model word
			for (int wordIx = 0; wordIx < splittedText.length; wordIx++) {
				String sWord = splittedText[wordIx];
				if (modelWords.contains((String) sWord)) {
					gotModelWords++;
					acceptedWordsThisLine.append(sWord + " ");
				}
			}
			testsWithModelWords[i] = acceptedWordsThisLine.toString();
		}

		// should we do do something if there is no modelWords?
		if (gotModelWords == 0) {
			result.append(
					"\nWarning!\nThe text to classify didn't contain a single\nword from the modelled words. This makes it hard for the classifier to\ndo something usefull.\nThe result may be weird.\n\n");
		}

		try {

			// add the ? class for all test cases
			String[] tmpClassValues = new String[tests.length];
			for (int i = 0; i < tmpClassValues.length; i++) {
				tmpClassValues[i] = "?";
			}

			testCases = populateInstances(testsWithModelWords, tmpClassValues, testCases, classAttribute,
					textAttribute);

			// result.append("TEST CASES before filter:\n" + testCases + "\n");

			Instances filteredTests = filterText(testCases);

			// result.append("TEST CASES:\n" + filteredTests + "\n");

			//
			// check
			//
			int startIx = instances.numInstances();
			result.append(checkCases(filteredTests, classifier, classAttribute, tests, "newcase", startIx) + "\n");

		} catch (Exception e) {
			e.printStackTrace();
			result.append("\nException (sorry!):\n" + e.toString());
		}

		return result;

	} // end classifyNewCases

	//
	// from empty instances populate with text and class arrays
	//
	public static Instances populateInstances(String[] theseInputTexts, String[] theseInputClasses,
			Instances theseInstances, Attribute classAttribute, Attribute textAttribute) {

		for (int i = 0; i < theseInputTexts.length; i++) {
			Instance inst = new Instance(2);
			inst.setValue(textAttribute, theseInputTexts[i]);
			if (theseInputClasses != null && theseInputClasses.length > 0) {
				inst.setValue(classAttribute, theseInputClasses[i]);
			}
			theseInstances.add(inst);
		}

		return theseInstances;

	} // populateInstances

	//
	// check instances (full set or just test cases)
	//
	public static StringBuffer checkCases(Instances theseInstances, Classifier thisClassifier,
			Attribute thisClassAttribute, String[] texts, String testType, int startIx) {

		StringBuffer result = new StringBuffer();

		try {

			result.append("\nCHECKING ALL THE INSTANCES:\n");

			Enumeration enumClasses = thisClassAttribute.enumerateValues();
			result.append("Class values (in order): ");
			while (enumClasses.hasMoreElements()) {
				String classStr = (String) enumClasses.nextElement();
				result.append("'" + classStr + "'  ");
			}
			result.append("\n");

			// startIx is a fix for handling text cases
			for (int i = startIx; i < theseInstances.numInstances(); i++) {

				SparseInstance sparseInst = new SparseInstance(theseInstances.instance(i));
				sparseInst.setDataset(theseInstances);

				result.append("\nTesting: '" + texts[i - startIx] + "'\n");
				// result.append("SparseInst: " + sparseInst + "\n");

				double correctValue = (double) sparseInst.classValue();
				double predictedValue = thisClassifier.classifyInstance(sparseInst);

				String predictString = thisClassAttribute.value((int) predictedValue) + " (" + predictedValue + ")";
				result.append("predicted: '" + predictString);
				// print comparison if not new case
				if (!"newcase".equals(testType)) {
					String correctString = thisClassAttribute.value((int) correctValue) + " (" + correctValue + ")";
					String testString = ((predictedValue == correctValue) ? "OK!" : "NOT OK!") + "!";
					result.append("' real class: '" + correctString + "' ==> " + testString);
				}
				result.append("\n");

				result.append("\n");
				// result.append(thisClassifier.dumpDistribution());
				// result.append("\n");
			}

		} catch (Exception e) {
			e.printStackTrace();
			result.append("\nException (sorry!):\n" + e.toString());
		}

		return result;

	} // end checkCases

	//
	// take instances in normal format (strings) and convert to Sparse format
	//
	public static Instances filterText(Instances theseInstances) {

		StringToWordVector filter = null;
		// default values according to Java Doc:
		int wordsToKeep = 1000;

		Instances filtered = null;

		try {

			filter = new StringToWordVector(wordsToKeep);
			// we ignore this for now...
			// filter.setDelimiters(delimitersStringToWordVector);
			filter.setOutputWordCounts(true);
			filter.setSelectedRange("1");

			filter.setInputFormat(theseInstances);

			filtered = weka.filters.Filter.useFilter(theseInstances, filter);
			// System.out.println("filtered:\n" + filtered);

		} catch (Exception e) {
			e.printStackTrace();
		}

		return filtered;

	} // end filterText

	//
	// information about classifier and evaluation
	//
	public static StringBuffer printClassifierAndEvaluation(Classifier thisClassifier, Evaluation thisEvaluation) {

		StringBuffer result = new StringBuffer();

		try {
			result.append("\n\nINFORMATION ABOUT THE CLASSIFIER AND EVALUATION:\n");
			result.append("\nclassifier.toString():\n" + thisClassifier.toString() + "\n");
			result.append("\nevaluation.toSummaryString(title, false):\n"
					+ thisEvaluation.toSummaryString("Summary", false) + "\n");
			result.append("\nevaluation.toMatrixString():\n" + thisEvaluation.toMatrixString() + "\n");
			result.append(
					"\nevaluation.toClassDetailsString():\n" + thisEvaluation.toClassDetailsString("Details") + "\n");
			result.append("\nevaluation.toCumulativeMarginDistribution:\n"
					+ thisEvaluation.toCumulativeMarginDistributionString() + "\n");
		} catch (Exception e) {
			e.printStackTrace();
			result.append("\nException (sorry!):\n" + e.toString());
		}

		return result;

	} // end printClassifierAndEvaluation

	//
	// setter for the classifier _string_
	//
	public void setClassifierString(String classString) {
		this.classString = classString;
	}

} // end class FbLikeClassifier
