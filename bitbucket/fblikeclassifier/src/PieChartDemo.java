

//package org.jfree.chart.demo;

import java.awt.Font;

import javax.swing.JPanel;

import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartPanel;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.PiePlot;
import org.jfree.data.general.DefaultPieDataset;
import org.jfree.data.general.PieDataset;
import org.jfree.ui.ApplicationFrame;
import org.jfree.ui.RefineryUtilities;

/**
 * A simple demonstration application showing how to create a pie chart using
 * data from a {@link DefaultPieDataset}.
 */
public class PieChartDemo extends ApplicationFrame {

	/**
	 * Default constructor.
	 *
	 * @param title
	 *            the frame title.
	 */
	public PieChartDemo(String title) {
		super(title);
		setContentPane(createDemoPanel());
	}

	/**
	 * Creates a sample dataset.
	 * 
	 * @return A sample dataset.
	 */
	private static PieDataset createDataset() {
		DefaultPieDataset dataset = new DefaultPieDataset();
		float total = var.count1 + var.count2 + var.count3;
		dataset.setValue("Technical ".concat(String.valueOf(var.count1/total*100)).concat("%"), new Double(var.count1));
		dataset.setValue("Entertainment ".concat(String.valueOf(var.count2/total*100)).concat("%"), new Double(var.count2));
		dataset.setValue("Other ".concat(String.valueOf(var.count3/total*100)).concat("%"), new Double(var.count3));

		return dataset;
	}

	/**
	 * Creates a chart.
	 * 
	 * @param dataset
	 *            the dataset.
	 * 
	 * @return A chart.
	 */
	private static JFreeChart createChart(PieDataset dataset) {

		JFreeChart chart = ChartFactory.createPieChart("Facebook user likes classification", // chart
																								// title
				dataset, // data
				true, // include legend
				true, false);

		PiePlot plot = (PiePlot) chart.getPlot();
		plot.setLabelFont(new Font("SansSerif", Font.PLAIN, 18));
		plot.setNoDataMessage("No data available");
		plot.setCircular(false);
		plot.setLabelGap(0.02);
		return chart;

	}

	/**
	 * Creates a panel for the demo (used by SuperDemo.java).
	 * 
	 * @return A panel.
	 */
	public static JPanel createDemoPanel() {
		JFreeChart chart = createChart(createDataset());
		return new ChartPanel(chart);
	}

	/**
	 * Starting point for the demonstration application.
	 *
	 * @param args
	 *            ignored.
	 */

}
